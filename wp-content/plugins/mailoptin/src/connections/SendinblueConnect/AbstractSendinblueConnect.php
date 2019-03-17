<?php

namespace MailOptin\SendinblueConnect;

use MailOptin\Core\Connections\AbstractConnect;
use MailOptin\Core\PluginSettings\Connections;
use MailOptin\Core\PluginSettings\Settings;
use MailOptin\Core\Repositories\OptinCampaignsRepository;

class AbstractSendinblueConnect extends AbstractConnect
{
    /** @var \MailOptin\Core\PluginSettings\Settings */
    protected $plugin_settings;

    /** @var \MailOptin\Core\PluginSettings\Connections */
    protected $connections_settings;

    protected $api_key;

    public function __construct()
    {
        $this->plugin_settings      = Settings::instance();
        $this->connections_settings = Connections::instance();
        $this->api_key              = $this->connections_settings->sendinblue_api_key();

        parent::__construct();
    }

    /**
     * Is Constant Contact successfully connected to?
     *
     * @return bool
     */
    public static function is_connected()
    {
        $db_options = get_option(MAILOPTIN_CONNECTIONS_DB_OPTION_NAME);

        return ! empty($db_options['sendinblue_api_key']);
    }

    public function get_integration_data($data_key, $integration_data = [], $default = '')
    {
        if (empty($integration_data) && ! empty($_POST['optin_campaign_id'])) {
            $optin_campaign_id = absint($_POST['optin_campaign_id']);
            $index             = absint($_POST['integration_index']);
            $val = json_decode(OptinCampaignsRepository::get_customizer_value($optin_campaign_id, 'integrations'), true);

            if(isset($val[$index])) {
                $integration_data = $val[$index];
            }
        }

        return parent::get_integration_data($data_key, $integration_data, $default);
    }

    public function get_first_name_attribute()
    {
        $firstname_key    = 'FIRSTNAME';
        $db_firstname_key = $this->get_integration_data('SendinblueConnect_first_name_field_key');

        if ( ! empty($db_firstname_key) && $db_firstname_key !== $firstname_key) {
            $firstname_key = $db_firstname_key;
        }

        return apply_filters('mo_connections_sendinblue_firstname_key', $firstname_key);
    }

    public function get_last_name_attribute()
    {
        $lastname_key    = 'LASTNAME';
        $db_lastname_key = $this->get_integration_data('SendinblueConnect_last_name_field_key');

        if ( ! empty($db_lastname_key) && $db_lastname_key !== $lastname_key) {
            $lastname_key = $db_lastname_key;
        }

        return apply_filters('mo_connections_sendinblue_lastname_key', $lastname_key);
    }

    /**
     * Return instance of convertkit API class.
     *
     * @throws \Exception
     *
     * @return APIClass
     */
    public function sendinblue_instance()
    {
        $api_key = $this->connections_settings->sendinblue_api_key();

        if (empty($api_key)) {
            throw new \Exception(__('SendinBlue API Key not found.', 'mailoptin'));
        }

        return new APIClass($api_key);
    }
}
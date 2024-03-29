(function() {

  function keywords(str) {

    var obj = {}, words = str.split(" ");

    for (var i = 0; i < words.length; ++i) obj[words[i]] = true;

    return obj;

  }

  function heredoc(delim) {

    return function(stream, state) {

      if (stream.match(delim)) state.tokenize = null;

      else stream.skipToEnd();

      return "string";

    }

  }

  var phpConfig = {

    name: "clike",

    keywords: keywords("abstract and array as break case catch class clone const continue declare default " +

                       "do else elseif enddeclare endfor endforeach endif endswitch endwhile extends final " +

                       "for foreach function global goto if implements interface instanceof namespace " +

                       "new or private protected public static switch throw trait try use var while xor " +

                       "die echo empty exit eval include include_once isset list require require_once return " +

                       "print unset __halt_compiler self static parent"),

    blockKeywords: keywords("catch do else elseif for foreach if switch try while"),

    atoms: keywords("true false null TRUE FALSE NULL"),

    multiLineStrings: true,

    hooks: {

      "$": function(stream, state) {

        stream.eatWhile(/[\w\$_]/);

        return "variable-2";

      },

      "<": function(stream, state) {

        if (stream.match(/<</)) {

          stream.eatWhile(/[\w\.]/);

          state.tokenize = heredoc(stream.current().slice(3));

          return state.tokenize(stream, state);

        }

        return false;

      },

      "#": function(stream, state) {

        while (!stream.eol() && !stream.match("?>", false)) stream.next();

        return "comment";

      },

      "/": function(stream, state) {

        if (stream.eat("/")) {

          while (!stream.eol() && !stream.match("?>", false)) stream.next();

          return "comment";

        }

        return false;

      }

    }

  };



  CodeMirror.defineMode("php", function(config, parserConfig) {

    var htmlMode = CodeMirror.getMode(config, {name: "xml", htmlMode: true});

    var jsMode = CodeMirror.getMode(config, "javascript");

    var cssMode = CodeMirror.getMode(config, "css");

    var phpMode = CodeMirror.getMode(config, phpConfig);



    function dispatch(stream, state) { // TODO open PHP inside text/css

      var isPHP = state.mode == "php";

      if (stream.sol() && state.pending != '"') state.pending = null;

      if (state.curMode == htmlMode) {

        if (stream.match(/^<\?\w*/)) {

          state.curMode = phpMode;

          state.curState = state.php;

          state.curClose = "?>";

	  state.mode = "php";

          return "meta";

        }

        if (state.pending == '"') {

          while (!stream.eol() && stream.next() != '"') {}

          var style = "string";

        } else if (state.pending && stream.pos < state.pending.end) {

          stream.pos = state.pending.end;

          var style = state.pending.style;

        } else {

          var style = htmlMode.token(stream, state.curState);

        }

        state.pending = null;

        var cur = stream.current(), openPHP = cur.search(/<\?/);

        if (openPHP != -1) {

          if (style == "string" && /\"$/.test(cur) && !/\?>/.test(cur)) state.pending = '"';

          else state.pending = {end: stream.pos, style: style};

          stream.backUp(cur.length - openPHP);

        } else if (style == "tag" && stream.current() == ">" && state.curState.context) {

          if (/^script$/i.test(state.curState.context.tagName)) {

            state.curMode = jsMode;

            state.curState = jsMode.startState(htmlMode.indent(state.curState, ""));

            state.curClose = /^<\/\s*script\s*>/i;

	    state.mode = "javascript";

          }

          else if (/^style$/i.test(state.curState.context.tagName)) {

            state.curMode = cssMode;

            state.curState = cssMode.startState(htmlMode.indent(state.curState, ""));

            state.curClose = /^<\/\s*style\s*>/i;

            state.mode = "css";

          }

        }

        return style;

      } else if ((!isPHP || state.php.tokenize == null) &&

                 stream.match(state.curClose, isPHP)) {

        state.curMode = htmlMode;

        state.curState = state.html;

        state.curClose = null;

	state.mode = "html";

        if (isPHP) return "meta";

        else return dispatch(stream, state);

      } else {

        return state.curMode.token(stream, state.curState);

      }

    }



    return {

      startState: function() {

        var html = htmlMode.startState();

        return {html: html,

                php: phpMode.startState(),

                curMode: parserConfig.startOpen ? phpMode : htmlMode,

                curState: parserConfig.startOpen ? phpMode.startState() : html,

                curClose: parserConfig.startOpen ? /^\?>/ : null,

		mode: parserConfig.startOpen ? "php" : "html",

                pending: null}

      },



      copyState: function(state) {

        var html = state.html, htmlNew = CodeMirror.copyState(htmlMode, html),

            php = state.php, phpNew = CodeMirror.copyState(phpMode, php), cur;

        if (state.curState == html) cur = htmlNew;

        else if (state.curState == php) cur = phpNew;

        else cur = CodeMirror.copyState(state.curMode, state.curState);

        return {html: htmlNew, php: phpNew, curMode: state.curMode, curState: cur,

                curClose: state.curClose, mode: state.mode,

                pending: state.pending};

      },



      token: dispatch,



      indent: function(state, textAfter) {

        if ((state.curMode != phpMode && /^\s*<\//.test(textAfter)) ||

            (state.curMode == phpMode && /^\?>/.test(textAfter)))

          return htmlMode.indent(state.html, textAfter);

        return state.curMode.indent(state.curState, textAfter);

      },



      electricChars: "/{}:"

    }

  }, "xml", "clike", "javascript", "css");

  CodeMirror.defineMIME("application/x-httpd-php", "php");

  CodeMirror.defineMIME("application/x-httpd-php-open", {name: "php", startOpen: true});

  CodeMirror.defineMIME("text/x-php", phpConfig);

})();


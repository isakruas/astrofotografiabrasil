
/*
 *  RScript.
 */
 "use strict";

 try {

    var Sys = {

        Info: {

            Version: function() {
                return ("1.0.1")
            }

        },

        Util: {
            Ping: function(host, port, pong) {
                var started = new Date().getTime();
                if (host == undefined && port == undefined && pong == undefined) {
                    host = 'http://wrmki.pe.hu';
                    port = 80;
                    pong = function(m) {
                        return (m);
                    }
                    try {
                        var http = new XMLHttpRequest();
                    } catch (a) {
                        try {
                            var http = new ActiveXObject("Msxml2.XMLHTTP");
                        } catch (b) {
                            try {
                                var http = new ActiveXObject("Microsoft.XMLHTTP");
                            } catch (c) {
                                var http = false;
                            }
                        }
                    }

                    if (http == false) {
                        throw new Error("Internal Error");
                    } else {
                        http.open("GET", host + ":" + port, /*async*/ true);
                        http.onreadystatechange = function() {
                            if (http.readyState == 4) {
                                var ended = new Date().getTime();

                                var milliseconds = ended - started;

                                if (pong != null) {
                                    pong(milliseconds);
                                }
                            }
                        }

                        try {
                            http.send(null);
                        } catch (exception) {
                            throw new Error("Internal Error");
                        }
                    }
                } else {
                    if (host == undefined) {
                        throw new Error("System.Util.Ping('http://wrmki.pe.hu', 80, function (milliseconds){console.log(milliseconds)});");
                    } else {
                        var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
                        if (!regex.test(host)) {
                            throw new Error("System.Util.Ping('http://wrmki.pe.hu', 80, function (milliseconds){console.log(milliseconds)});");
                        } else {
                            if (port == undefined) {
                                throw new Error("System.Util.Ping('http://wrmki.pe.hu', 80, function (milliseconds){console.log(milliseconds)});");

                            } else {
                                if (pong == undefined) {
                                    throw new Error("System.Util.Ping('http://wrmki.pe.hu', 80, function (milliseconds){console.log(milliseconds)});");
                                } else {

                                    try {
                                        var http = new XMLHttpRequest();
                                    } catch (a) {
                                        try {
                                            var http = new ActiveXObject("Msxml2.XMLHTTP");
                                        } catch (b) {
                                            try {
                                                var http = new ActiveXObject("Microsoft.XMLHTTP");
                                            } catch (c) {
                                                var http = false;
                                            }
                                        }
                                    }

                                    if (http == false) {
                                        throw new Error("Internal Error");
                                    } else {
                                        http.open("GET", host + ":" + port, /*async*/ true);
                                        http.onreadystatechange = function() {
                                            if (http.readyState == 4) {
                                                var ended = new Date().getTime();

                                                var milliseconds = ended - started;

                                                if (pong != null) {
                                                    pong(milliseconds);
                                                }
                                            }
                                        }

                                        try {
                                            http.send(null);
                                        } catch (exception) {
                                            throw new Error("Internal Error");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        },

        Ready: function(data, func) {

            if (data == undefined && func == undefined) {
                throw new Error('System.Ready({status:"complete"}, function(ObjectHTMLDocument){console.log(ObjectHTMLDocument)});');
            } else {

                if (data !== undefined && func == undefined) {
                    // verificar se ela e um objeto ou uma funcao
                    // se for uma funcao executala

                    if (typeof data == "object") {
                        throw new Error('System.Ready({status:"complete"}, function(ObjectHTMLDocument){console.log(ObjectHTMLDocument)});');
                    } else {
                        if (typeof data == "function") {
                            // data = func 
                            // executar funcao
                            func = data;

                            document.onreadystatechange = function() {

                                switch (document.readyState) {

                                    case "complete":

                                    func(document);
                                    console.log("System.Ready()");

                                    break;
                                }

                            }

                        } else {
                            throw new Error('System.Ready({status:"complete"}, function(ObjectHTMLDocument){console.log(ObjectHTMLDocument)});');
                        }
                    }

                } else {

                    if (data == undefined && func !== undefined) {
                        // a data e igual a funcao
                        // executar a funcao

                        if (typeof func == "object") {
                            throw new Error('System.Ready({status:"complete"}, function(ObjectHTMLDocument){console.log(ObjectHTMLDocument)});');
                        } else {
                            if (typeof func == "function") {
                                // data = func 
                                // executar funcao
                                func = data;

                                document.onreadystatechange = function() {

                                    switch (document.readyState) {

                                        case "complete":

                                        func(document);
                                        console.log("System.Ready()");

                                        break;
                                    }

                                }

                            } else {
                                throw new Error('System.Ready({status:"complete"}, function(ObjectHTMLDocument){console.log(ObjectHTMLDocument)});');
                            }
                        }

                    } else {

                        if (data !== undefined && func !== undefined) {
                            // verificar condicional de status
                            // executar a funcao
                            if (data.status !== undefined) {} else {
                                data.status = "complete";
                            }

                            document.onreadystatechange = function() {

                                switch (document.readyState) {

                                    case "loading":
                                    if (data.status == "loading") {
                                        func(document);
                                        console.log("System.Ready()");
                                    }
                                    break;

                                    case "interactive":
                                    if (data.status == "interactive") {
                                        func(document);
                                        console.log("System.Ready()");
                                    }
                                    break;

                                    case "complete":
                                    if (data.status == "complete") {
                                        func(document);
                                        console.log("System.Ready()");
                                    }
                                    break;
                                }

                            }

                        }

                    }

                }

            }

        },

        Ajax: {

            Get: function(json) {

                if (json !== undefined) {

                    if (typeof json == "object") {

                        // Checks if the parameter was passed.
                        if (json.url == undefined) {
                            json.url = "/";
                        }

                        // Checks if the parameter was passed.
                        if (json.data == undefined) {
                            json.data = "";
                        }

                        // Checks if the parameter was passed.
                        if (json.success == undefined) {
                            json.success = function() {};
                        }

                        // Checks if the parameter was passed.
                        if (json.error == undefined) {
                            json.error = function() {};
                        }

                        // Checks if the parameter was passed.
                        if (json.first == undefined) {
                            json.first = function() {};
                        }

                        // Checks if the parameter was passed.
                        if (json.error == undefined) {
                            json.error = function() {};
                        }

                        if (json.last == undefined) {
                            json.last = function() {};
                        }

                        json.first();

                        try {
                            var get = new XMLHttpRequest();
                        } catch (a) {
                            try {
                                var get = new ActiveXObject("Msxml2.XMLHTTP");
                            } catch (b) {
                                try {
                                    var get = new ActiveXObject("Microsoft.XMLHTTP");
                                } catch (c) {
                                    var get = false;
                                }
                            }
                        }

                        // Send request.
                        get.open("GET", json.url + "?" + json.data, true);
                        // Builds a scan input.
                        get.onreadystatechange = function() {

                            if(document.getElementById("progress")) {
                                 switch (this.readyState) {
                                    case 0:
                                    document.getElementById("progress").value = "0";
                                    break;
                                    case 1:
                                    document.getElementById("progress").value = "25";
                                    break;
                                    case 2:
                                    document.getElementById("progress").value = "50";
                                    break;
                                    case 3:
                                    document.getElementById("progress").value = "75";
                                    break;
                                    case 4:
                                    document.getElementById("progress").value = "100";

                                    if (this.status >= 200 && this.status < 299) {
                                        var resp = this.responseText;
                                        json.success(resp);
                                        json.last();
                                        document.getElementById("progress").value = "0";

                                    } else {
                                        json.error();
                                        document.getElementById("progress").value = "0";
                                    }

                                    break;
                                }
                            } else {
                                if (this.readyState === 4) {
                                    if (this.status >= 200 && this.status < 299) {
                                        var resp = this.responseText;
                                        json.success(resp);
                                        json.last();
                                    } else {
                                        json.error();
                                    }
                                }
                            }
                        }

                        get.send(null);
                        console.log("System.Ajax.Get()");

                    } else {
                        throw new Error('System.Ajax.Get({url:"", data:"", first:function(){}, success:function(){}, last:function(){}, error:function(){}});');
                    }

                } else {

                    throw new Error('System.Ajax.Get({url:"", data:"", first:function(){}, success:function(){}, last:function(){}, error:function(){}});');
                }

            },

            Post: function(json) {

                if (json !== undefined) {

                    if (typeof json == "object") {

                        // Checks if the parameter was passed.
                        if (json.url == undefined) {
                            json.url = "/";
                        }

                        // Checks if the parameter was passed.
                        if (json.data == undefined) {
                            json.data = "";
                        }

                        // Checks if the parameter was passed.
                        if (json.success == undefined) {
                            json.success = function() {};
                        }

                        // Checks if the parameter was passed.
                        if (json.error == undefined) {
                            json.error = function() {};
                        }

                        // Checks if the parameter was passed.
                        if (json.first == undefined) {
                            json.first = function() {};
                        }

                        // Checks if the parameter was passed.
                        if (json.error == undefined) {
                            json.error = function() {};
                        }

                        if (json.last == undefined) {
                            json.last = function() {};
                        }

                        json.first();

                        // Identifies which browser and load base files.
                        try {
                            var post = new XMLHttpRequest();
                        } catch (a) {
                            try {
                                var post = new ActiveXObject("Msxml2.XMLHTTP");
                            } catch (b) {
                                try {
                                    var post = new ActiveXObject("Microsoft.XMLHTTP");
                                } catch (c) {
                                    var post = false;
                                }
                            }
                        }

                        // Builds a scan input.
                        post.onreadystatechange = function() {
                            if(document.getElementById("progress")) {
                                 switch (this.readyState) {
                                    case 0:
                                    document.getElementById("progress").value = "0";
                                    break;
                                    case 1:
                                    document.getElementById("progress").value = "25";
                                    break;
                                    case 2:
                                    document.getElementById("progress").value = "50";
                                    break;
                                    case 3:
                                    document.getElementById("progress").value = "75";
                                    break;
                                    case 4:
                                    document.getElementById("progress").value = "100";

                                    if (this.status >= 200 && this.status < 299) {
                                        var resp = this.responseText;
                                        json.success(resp);
                                        json.last();
                                        document.getElementById("progress").value = "0";
                                         
                                    } else {
                                        json.error();
                                        document.getElementById("progress").value = "0";
                                    }

                                    break;
                                }
                            } else {
                                if (this.readyState === 4) {
                                    if (this.status >= 200 && this.status < 299) {
                                        var resp = this.responseText;
                                        json.success(resp);
                                        json.last();
                                    } else {
                                        json.error();
                                    }
                                }
                            }
                        }
                        // Send request.
                        post.open('POST', json.url, true);
                        post.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        post.send(json.data);

                        console.log("System.Ajax.Post()");

                    } else {
                        throw new Error('System.Ajax.Post({url:"", data:"", first:function(){}, success:function(){}, last:function(){}, error:function(){}});');
                    }

                } else {
                    throw new Error('System.Ajax.Post({url:"", data:"", first:function(){}, success:function(){}, last:function(){}, error:function(){}});');
                }
            }

        }

    };

    var System = Object.create(Sys);

} catch (e) {

    throw new Error(e);

} finally {

    console.log("RScript " + System.Info.Version() + " Started");

}






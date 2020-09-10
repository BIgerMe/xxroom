webpackJsonp([24], {
    "06xx": function(e, t) {},
    DpK5: function(e, t) {},
    E51W: function(e, t) {},
    HRs4: function(e, t) {},
    NHnr: function(e, t, n) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var o = n("7+uW"),
        a = {
            render: function() {
                var e = this.$createElement,
                t = this._self._c || e;
                return t("div", {
                    attrs: {
                        id: "app"
                    }
                },
                [t("keep-alive", [this.$route.meta.keepAlive ? t("router-view") : this._e()], 1), this._v(" "), this.$route.meta.keepAlive ? this._e() : t("router-view")], 1)
            },
            staticRenderFns: []
        };
        var i = n("VU/8")({
            name: "app"
        },
        a, !1,
        function(e) {
            n("YVbH")
        },
        null, null).exports,
        r = n("/ocq"),
        l = {
            render: function() {
                var e = this.$createElement,
                t = this._self._c || e;
                return t("div", {
                    staticClass: "index"
                },
                [this._m(0), this._v(" "), t("div", {
                    staticClass: "main"
                },
                [t("yd-cell-group", [t("yd-cell-item", [t("input", {
                    attrs: {
                        slot: "right",
                        type: "number",
                        placeholder: "请输入手机号"
                    },
                    slot: "right"
                })])], 1)], 1), this._v(" "), t("footer")])
            },
            staticRenderFns: [function() {
                var e = this.$createElement,
                t = this._self._c || e;
                return t("header", [t("img", {
                    attrs: {
                        src: n("rXCW")
                    }
                })])
            }]
        };
        var u = n("VU/8")({
            name: "HelloWorld",
            data: function() {
                return {
                    msg: "Welcome to Your Vue.js App"
                }
            },
            created: function() {},
            methods: {}
        },
        l, !1,
        function(e) {
            n("06xx")
        },
        "data-v-86ff1972", null).exports;
        o.
    default.use(r.a);
        var c = new r.a({
            base: "/panasonic/",
            mode: "history",
            routes: [{
                path: "/",
                name: "HelloWorld",
                component: u
            },
            {
                path: "/index1",
                name: "index",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(17)]).then(function() {
                        return e(n("8/c5"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/index2",
                name: "index2",
                component: function(e) {
                    return n.e(14).then(function() {
                        return e(n("QbgG"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/login/login",
                name: "login",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(13)]).then(function() {
                        return e(n("QrVH"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/login/register",
                name: "register",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(16)]).then(function() {
                        return e(n("4R6/"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/add/yanzheng",
                name: "yanzheng",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(15)]).then(function() {
                        return e(n("EB6B"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/add/tijiao",
                name: "tijiao",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(2)]).then(function() {
                        return e(n("1Gvp"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/add/saoma",
                name: "saoma",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(19)]).then(function() {
                        return e(n("Xnby"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/add/yaoqing",
                name: "yaoqing",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(21)]).then(function() {
                        return e(n("xuBj"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/add/jinjianOk",
                name: "jinjianOk",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(11)]).then(function() {
                        return e(n("Yvi7"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/state/state",
                name: "state",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(12)]).then(function() {
                        return e(n("1yUM"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/state/showCode",
                name: "showCode",
                component: function(e) {
                    return n.e(8).then(function() {
                        return e(n("ZHPX"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/state/skip",
                name: "skip",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(4)]).then(function() {
                        return e(n("ILCS"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/text",
                name: "text",
                component: function(e) {
                    return n.e(22).then(function() {
                        return e(n("oCab"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/add/newyanzheng",
                name: "newyanzheng",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(7)]).then(function() {
                        return e(n("1j8G"))
                    }.bind(null, n)).
                    catch(n.oe)
                },
                meta: {
                    keepAlive: !0
                }
            },
            {
                path: "/supercode/superyanzheng",
                name: "superyanzheng",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(3)]).then(function() {
                        return e(n("48Fz"))
                    }.bind(null, n)).
                    catch(n.oe)
                },
                meta: {
                    keepAlive: !0
                }
            },
            {
                path: "/supercode/superBusinessyanzheng",
                name: "superBusinessyanzheng",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(1)]).then(function() {
                        return e(n("PgWX"))
                    }.bind(null, n)).
                    catch(n.oe)
                },
                meta: {
                    keepAlive: !0
                }
            },
            {
                path: "/supercode/swrong",
                name: "swrong",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(18)]).then(function() {
                        return e(n("b/9O"))
                    }.bind(null, n)).
                    catch(n.oe)
                },
                meta: {
                    keepAlive: !0
                }
            },
            {
                path: "/supercode/superRegister",
                name: "superRegister",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(9)]).then(function() {
                        return e(n("9LrE"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/supercode/superLogin",
                name: "superLogin",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(10)]).then(function() {
                        return e(n("UGot"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/supercode/authorization",
                name: "authorization",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(20)]).then(function() {
                        return e(n("5ZMa"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            },
            {
                path: "/supercode/guide",
                name: "guide",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(5)]).then(function() {
                        return e(n("wHXv"))
                    }.bind(null, n)).
                    catch(n.oe)
                },
                meta: {
                    keepAlive: !0
                }
            },
            {
                path: "/supercode/choice",
                name: "choice",
                component: function(e) {
                    return Promise.all([n.e(0), n.e(6)]).then(function() {
                        return e(n("bMnN"))
                    }.bind(null, n)).
                    catch(n.oe)
                }
            }]
        }),
        m = (n("DpK5"), n("ZpAt"), n("HRs4"), n("m9eN")),
        p = n("4dIB"),
        s = n("XUVj"),
        d = n("DsJA"),
        h = n("pkfk"),
        f = n("Zvjp"),
        b = n("25y4"),
        g = n("3oqm"),
        v = n("gwGT"),
        x = n("GVib"),
        y = n("u64Q"),
        w = n.n(y),
        B = (n("E51W"), n("l8x0")),
        P = n("Xddw"),
        k = n("pMDt");
        o.
    default.component(m.Button.name, m.Button),
        o.
    default.component(m.ButtonGroup.name, m.ButtonGroup),
        o.
    default.component(p.NavBar.name, p.NavBar),
        o.
    default.component(p.NavBarBackIcon.name, p.NavBarBackIcon),
        o.
    default.component(p.NavBarNextIcon.name, p.NavBarNextIcon),
        o.
    default.component(s.CellGroup.name, s.CellGroup),
        o.
    default.component(s.CellItem.name, s.CellItem),
        o.
    default.component(d.DateTime.name, d.DateTime),
        o.
    default.component(h.CitySelect.name, h.CitySelect),
        o.
    default.component(f.ActionSheet.name, f.ActionSheet),
        o.
    default.component(g.Input.name, g.Input),
        o.
    default.component(v.Popup.name, v.Popup),
        o.
    default.component(x.CheckBox.name, x.CheckBox),
        o.
    default.component(x.CheckBoxGroup.name, x.CheckBoxGroup),
        o.
    default.config.productionTip = !1,
        o.
    default.use(w.a),
        new o.
    default({
            el:
            "#app",
            router: c,
            template: "<App/>",
            components: {
                App: i
            }
        }),
        o.
    default.prototype.$dialog = {
            confirm: b.Confirm,
            alert: b.Alert,
            toast: b.Toast,
            notify: b.Notify,
            loading: b.Loading
        },
        o.
    default.component(B.Tab.name, B.Tab),
        o.
    default.component(B.TabPanel.name, B.TabPanel),
        o.
    default.component(P.Radio.name, P.Radio),
        o.
    default.component(P.RadioGroup.name, P.RadioGroup),
        o.
    default.component(k.FlexBox.name, k.FlexBox),
        o.
    default.component(k.FlexBoxItem.name, k.FlexBoxItem)
    },
    YVbH: function(e, t) {},
    ZpAt: function(e, t) { !
        function() {
            var e = "@charset \"utf-8\";html{color:#000;background:#fff;overflow-y:scroll;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}html *{outline:0;-webkit-text-size-adjust:none;-webkit-tap-highlight-color:rgba(0,0,0,0)}html,body{font-family:sans-serif}body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td,hr,button,article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{margin:0;padding:0}input,select,textarea{font-size:100%}table{border-collapse:collapse;border-spacing:0}fieldset,img{border:0}abbr,acronym{border:0;font-variant:normal}del{text-decoration:line-through}address,caption,cite,code,dfn,em,th,var{font-style:normal;font-weight:500}ol,ul{list-style:none}caption,th{text-align:left}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:500}q:before,q:after{content:''}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sup{top:-.5em}sub{bottom:-.25em}a:hover{text-decoration:underline}ins,a{text-decoration:none}",
            t = document.createElement("style");
            if (document.getElementsByTagName("head")[0].appendChild(t), t.styleSheet) t.styleSheet.disabled || (t.styleSheet.cssText = e);
            else try {
                t.innerHTML = e
            } catch(n) {
                t.innerText = e
            }
        } (),
        function(e, t) {
            function n() {
                var t = i.getBoundingClientRect().width;
                t / u > 540 && (t = 540 * u);
                var n = t / 10;
                i.style.fontSize = n + "px",
                m.rem = e.rem = n
            }
            var o, a = e.document,
            i = a.documentElement,
            r = a.querySelector('meta[name="viewport"]'),
            l = a.querySelector('meta[name="flexible"]'),
            u = 0,
            c = 0,
            m = t.flexible || (t.flexible = {});
            if (r) {
                console.warn("将根据已有的meta标签来设置缩放比例");
                var p = r.getAttribute("content").match(/initial\-scale=([\d\.]+)/);
                p && (c = parseFloat(p[1]), u = parseInt(1 / c))
            } else if (l) {
                var s = l.getAttribute("content");
                if (s) {
                    var d = s.match(/initial\-dpr=([\d\.]+)/),
                    h = s.match(/maximum\-dpr=([\d\.]+)/);
                    d && (u = parseFloat(d[1]), c = parseFloat((1 / u).toFixed(2))),
                    h && (u = parseFloat(h[1]), c = parseFloat((1 / u).toFixed(2)))
                }
            }
            if (!u && !c) {
                var f = (e.navigator.appVersion.match(/android/gi), e.navigator.appVersion.match(/iphone/gi)),
                b = e.devicePixelRatio;
                c = 1 / (u = f ? b >= 3 && (!u || u >= 3) ? 3 : b >= 2 && (!u || u >= 2) ? 2 : 1 : 1)
            }
            if (i.setAttribute("data-dpr", u), !r) if ((r = a.createElement("meta")).setAttribute("name", "viewport"), r.setAttribute("content", "initial-scale=" + c + ", maximum-scale=" + c + ", minimum-scale=" + c + ", user-scalable=no"), i.firstElementChild) i.firstElementChild.appendChild(r);
            else {
                var g = a.createElement("div");
                g.appendChild(r),
                a.write(g.innerHTML)
            }
            e.addEventListener("resize",
            function() {
                clearTimeout(o),
                o = setTimeout(n, 300)
            },
            !1),
            e.addEventListener("pageshow",
            function(e) {
                e.persisted && (clearTimeout(o), o = setTimeout(n, 300))
            },
            !1),
            "complete" === a.readyState ? a.body.style.fontSize = 12 * u + "px": a.addEventListener("DOMContentLoaded",
            function() {
                a.body.style.fontSize = 12 * u + "px"
            },
            !1),
            n(),
            m.dpr = e.dpr = u,
            m.refreshRem = n,
            m.rem2px = function(e) {
                var t = parseFloat(e) * this.rem;
                return "string" == typeof e && e.match(/rem$/) && (t += "px"),
                t
            },
            m.px2rem = function(e) {
                var t = parseFloat(e) / this.rem;
                return "string" == typeof e && e.match(/px$/) && (t += "rem"),
                t
            }
        } (window, window.lib || (window.lib = {}))
    },
    rXCW: function(e, t, n) {
        e.exports = n.p + "static/img/woyaobangding_bg_logo@2x.c9b4faf.png"
    }
},
["NHnr"]);
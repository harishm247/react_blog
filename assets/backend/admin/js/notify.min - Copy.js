(function(e) {
    typeof define == "function" && define.amd ? define(["jquery"], e) : typeof module == "object" && module.exports ? module.exports = function(t, n) {
        return n === undefined && (typeof window != "undefined" ? n = require("jquery") : n = require("jquery")(t)), e(n), n
    } : e(jQuery)
})(function(e) {
    function A(t, n, i) {
        typeof i == "string" && (i = {
            className: i
        }), this.options = E(w, e.isPlainObject(i) ? i : {}), this.loadHTML(), this.wrapper = e(h.html), this.options.clickToHide && this.wrapper.addClass(r + "-hidable"), this.wrapper.data(r, this), this.arrow = this.wrapper.find("." + r + "-arrow"), this.container = this.wrapper.find("." + r + "-container"), this.container.append(this.userContainer), t && t.length && (this.elementType = t.attr("type"), this.originalElement = t, this.elem = N(t), this.elem.data(r, this), this.elem.before(this.wrapper)), this.container.hide(), this.run(n)
    }
    var t = [].indexOf || function(e) {
            for (var t = 0, n = this.length; t < n; t++)
                if (t in this && this[t] === e) return t;
            return -1
        },
        n = "notify",
        r = n + "js",
        i = n + "!blank",
        s = {
            t: "top",
            m: "middle",
            b: "bottom",
            l: "left",
            c: "center",
            r: "right"
        },
        o = ["l", "c", "r"],
        u = ["t", "m", "b"],
        a = ["t", "b", "l", "r"],
        f = {
            t: "b",
            m: null,
            b: "t",
            l: "r",
            c: null,
            r: "l"
        },
        l = function(t) {
            var n;
            return n = [], e.each(t.split(/\W+/), function(e, t) {
                var r;
                r = t.toLowerCase().charAt(0);
                if (s[r]) return n.push(r)
            }), n
        },
        c = {},
        h = {
            name: "core",
            html: '<div class="' + r + '-wrapper">\n	<div class="' + r + '-arrow"></div>\n	<div class="' + r + '-container"></div>\n</div>',
            css: "." + r + "-corner {\n	position: fixed;\n	margin: 5px;\n	z-index: 1050;\n}\n\n." + r + "-corner ." + r + "-wrapper,\n." + r + "-corner ." + r + "-container {\n	position: relative;\n	display: block;\n	height: inherit;\n	width: inherit;\n	margin: 3px;\n}\n\n." + r + "-wrapper {\n	z-index: 1;\n	position: absolute;\n	display: inline-block;\n	height: 0;\n	width: 0;\n}\n\n." + r + "-container {\n	display: none;\n	z-index: 1;\n	position: absolute;\n}\n\n." + r + "-hidable {\n	cursor: pointer;\n}\n\n[data-notify-text],[data-notify-html] {\n	position: relative;\n}\n\n." + r + "-arrow {\n	position: absolute;\n	z-index: 2;\n	width: 0;\n	height: 0;\n}"
        },
        p = {
            "border-radius": ["-webkit-", "-moz-"]
        },
        d = function(e) {
            return c[e]
        },
        v = function(e) {
            if (!e) throw "Missing Style name";
            c[e] && delete c[e]
        },
        m = function(t, i) {
            if (!t) throw "Missing Style name";
            if (!i) throw "Missing Style definition";
            if (!i.html) throw "Missing Style HTML";
            var s = c[t];
            s && s.cssElem && (window.console && console.warn(n + ": overwriting style '" + t + "'"), c[t].cssElem.remove()), i.name = t, c[t] = i;
            var o = "";
            i.classes && e.each(i.classes, function(t, n) {
                return o += "." + r + "-" + i.name + "-" + t + " {\n", e.each(n, function(t, n) {
                    return p[t] && e.each(p[t], function(e, r) {
                        return o += "	" + r + t + ": " + n + ";\n"
                    }), o += "	" + t + ": " + n + ";\n"
                }), o += "}\n"
            }), i.css && (o += "/* styles for " + i.name + " */\n" + i.css), o && (i.cssElem = g(o), i.cssElem.attr("id", "notify-" + i.name));
            var u = {},
                a = e(i.html);
            y("html", a, u), y("text", a, u), i.fields = u
        },
        g = function(t) {
            var n, r, i;
            r = x("style"), r.attr("type", "text/css"), e("head").append(r);
            try {
                r.html(t)
            } catch (s) {
                r[0].styleSheet.cssText = t
            }
            return r
        },
        y = function(t, n, r) {
            var s;
            return t !== "html" && (t = "text"), s = "data-notify-" + t, b(n, "[" + s + "]").each(function() {
                var n;
                n = e(this).attr(s), n || (n = i), r[n] = t
            })
        },
        b = function(e, t) {
            return e.is(t) ? e : e.find(t)
        },
        w = {
            clickToHide: !0,
            autoHide: !0,
            autoHideDelay: 5e3,
            arrowShow: !0,
            arrowSize: 5,
            breakNewLines: !0,
            elementPosition: "bottom",
            globalPosition: "bottom right",
            style: "bootstrap",
            className: "error",
            showAnimation: "slideDown",
            showDuration: 400,
            hideAnimation: "slideUp",
            hideDuration: 200,
            gap: 5
        },
        E = function(t, n) {
            var r;
            return r = function() {}, r.prototype = t, e.extend(!0, new r, n)
        },
        S = function(t) {
            return e.extend(w, t)
        },
        x = function(t) {
            return e("<" + t + "></" + t + ">")
        },
        T = {},
        N = function(t) {
            var n;
            return t.is("[type=radio]") && (n = t.parents("form:first").find("[type=radio]").filter(function(n, r) {
                return e(r).attr("name") === t.attr("name")
            }), t = n.first()), t
        },
        C = function(e, t, n) {
            var r, i;
            if (typeof n == "string") n = parseInt(n, 10);
            else if (typeof n != "number") return;
            if (isNaN(n)) return;
            return r = s[f[t.charAt(0)]], i = t, e[r] !== undefined && (t = s[r.charAt(0)], n = -n), e[t] === undefined ? e[t] = n : e[t] += n, null
        },
        k = function(e, t, n) {
            if (e === "l" || e === "t") return 0;
            if (e === "c" || e === "m") return n / 2 - t / 2;
            if (e === "r" || e === "b") return n - t;
            throw "Invalid alignment"
        },
        L = function(e) {
            return L.e = L.e || x("div"), L.e.text(e).html()
        };
    A.prototype.loadHTML = function() {
        var t;
        t = this.getStyle(), this.userContainer = e(t.html), this.userFields = t.fields
    }, A.prototype.show = function(e, t) {
        var n, r, i, s, o;
        r = function(n) {
            return function() {
                !e && !n.elem && n.destroy();
                if (t) return t()
            }
        }(this), o = this.container.parent().parents(":hidden").length > 0, i = this.container.add(this.arrow), n = [];
        if (o && e) s = "show";
        else if (o && !e) s = "hide";
        else if (!o && e) s = this.options.showAnimation, n.push(this.options.showDuration);
        else {
            if (!!o || !!e) return r();
            s = this.options.hideAnimation, n.push(this.options.hideDuration)
        }
        return n.push(r), i[s].apply(i, n)
    }, A.prototype.setGlobalPosition = function() {
        var t = this.getPosition(),
            n = t[0],
            i = t[1],
            o = s[n],
            u = s[i],
            a = n + "|" + i,
            f = T[a];
        if (!f || !document.body.contains(f[0])) {
            f = T[a] = x("div");
            var l = {};
            l[o] = 0, u === "middle" ? l.top = "45%" : u === "center" ? l.left = "45%" : l[u] = 0, f.css(l).addClass(r + "-corner"), e("body").append(f)
        }
        return f.prepend(this.wrapper)
    }, A.prototype.setElementPosition = function() {
        var n, r, i, l, c, h, p, d, v, m, g, y, b, w, E, S, x, T, N, L, A, O, M, _, D, P, H, B, j;
        H = this.getPosition(), _ = H[0], O = H[1], M = H[2], g = this.elem.position(), d = this.elem.outerHeight(), y = this.elem.outerWidth(), v = this.elem.innerHeight(), m = this.elem.innerWidth(), j = this.wrapper.position(), c = this.container.height(), h = this.container.width(), T = s[_], L = f[_], A = s[L], p = {}, p[A] = _ === "b" ? d : _ === "r" ? y : 0, C(p, "top", g.top - j.top), C(p, "left", g.left - j.left), B = ["top", "left"];
        for (w = 0, S = B.length; w < S; w++) D = B[w], N = parseInt(this.elem.css("margin-" + D), 10), N && C(p, D, N);
        b = Math.max(0, this.options.gap - (this.options.arrowShow ? i : 0)), C(p, A, b);
        if (!this.options.arrowShow) this.arrow.hide();
        else {
            i = this.options.arrowSize, r = e.extend({}, p), n = this.userContainer.css("border-color") || this.userContainer.css("border-top-color") || this.userContainer.css("background-color") || "white";
            for (E = 0, x = a.length; E < x; E++) {
                D = a[E], P = s[D];
                if (D === L) continue;
                l = P === T ? n : "transparent", r["border-" + P] = i + "px solid " + l
            }
            C(p, s[L], i), t.call(a, O) >= 0 && C(r, s[O], i * 2)
        }
        t.call(u, _) >= 0 ? (C(p, "left", k(O, h, y)), r && C(r, "left", k(O, i, m))) : t.call(o, _) >= 0 && (C(p, "top", k(O, c, d)), r && C(r, "top", k(O, i, v))), this.container.is(":visible") && (p.display = "block"), this.container.removeAttr("style").css(p);
        if (r) return this.arrow.removeAttr("style").css(r)
    }, A.prototype.getPosition = function() {
        var e, n, r, i, s, f, c, h;
        h = this.options.position || (this.elem ? this.options.elementPosition : this.options.globalPosition), e = l(h), e.length === 0 && (e[0] = "b");
        if (n = e[0], t.call(a, n) < 0) throw "Must be one of [" + a + "]";
        if (e.length === 1 || (r = e[0], t.call(u, r) >= 0) && (i = e[1], t.call(o, i) < 0) || (s = e[0], t.call(o, s) >= 0) && (f = e[1], t.call(u, f) < 0)) e[1] = (c = e[0], t.call(o, c) >= 0) ? "m" : "l";
        return e.length === 2 && (e[2] = e[1]), e
    }, A.prototype.getStyle = function(e) {
        var t;
        e || (e = this.options.style), e || (e = "default"), t = c[e];
        if (!t) throw "Missing style: " + e;
        return t
    }, A.prototype.updateClasses = function() {
        var t, n;
        return t = ["base"], e.isArray(this.options.className) ? t = t.concat(this.options.className) : this.options.className && t.push(this.options.className), n = this.getStyle(), t = e.map(t, function(e) {
            return r + "-" + n.name + "-" + e
        }).join(" "), this.userContainer.attr("class", t)
    }, A.prototype.run = function(t, n) {
        var r, s, o, u, a;
        e.isPlainObject(n) ? e.extend(this.options, n) : e.type(n) === "string" && (this.options.className = n);
        if (this.container && !t) {
            this.show(!1);
            return
        }
        if (!this.container && !t) return;
        s = {}, e.isPlainObject(t) ? s = t : s[i] = t;
        for (o in s) {
            r = s[o], u = this.userFields[o];
            if (!u) continue;
            u === "text" && (r = L(r), this.options.breakNewLines && (r = r.replace(/\n/g, "<br/>"))), a = o === i ? "" : "=" + o, b(this.userContainer, "[data-notify-" + u + a + "]").html(r)
        }
        this.updateClasses(), this.elem ? this.setElementPosition() : this.setGlobalPosition(), this.show(!0), this.options.autoHide && (clearTimeout(this.autohideTimer), this.autohideTimer = setTimeout(this.show.bind(this, !1), this.options.autoHideDelay))
    }, A.prototype.destroy = function() {
        this.wrapper.data(r, null), this.wrapper.remove()
    }, e[n] = function(t, r, i) {
        return t && t.nodeName || t.jquery ? e(t)[n](r, i) : (i = r, r = t, new A(null, r, i)), t
    }, e.fn[n] = function(t, n) {
        return e(this).each(function() {
            var i = N(e(this)).data(r);
            i && i.destroy();
            var s = new A(e(this), t, n)
        }), this
    }, e.extend(e[n], {
        defaults: S,
        addStyle: m,
        removeStyle: v,
        pluginOptions: w,
        getStyle: d,
        insertCSS: g
    }), m("bootstrap", {
        html: "<div class='custom-alert-popup'>\n<span data-notify-text></span>\n</div>",
        classes: {
            base: {
            	"font-size": "16px",
                "font-weight": "600",
                padding: "30px 40px",
                "background-color": "#f9f9f9",
                border: "1px solid #ddd",
                "border-radius": "4px",
                "white-space": "normal",
                "padding-left": "90px",
                "background-repeat": "no-repeat",
                "background-position": "6% 50%",
                "box-shadow": "0 0 7px rgba(0, 0, 0, 0.4)",
                "margin-bottom": "15px",
                "margin-right": "15px",
                "position":"relative",
                "width":"450px",
                "text-align":"center"

            },
            error: {
                color: "#fff",
                "background-color": "#ac2925",
                "border-color": "#761c19",
                "background-image": "url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAxMjkgMTI5IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCAxMjkgMTI5IiB3aWR0aD0iMTI4cHgiIGhlaWdodD0iMTI4cHgiPgogIDxnPgogICAgPGc+CiAgICAgIDxwYXRoIGQ9Ik02NC41LDEyMi42YzMyLDAsNTguMS0yNiw1OC4xLTU4LjFTOTYuNSw2LjQsNjQuNSw2LjRTNi40LDMyLjUsNi40LDY0LjVTMzIuNSwxMjIuNiw2NC41LDEyMi42eiBNNjQuNSwxNC42ICAgIGMyNy41LDAsNDkuOSwyMi40LDQ5LjksNDkuOVM5MiwxMTQuNCw2NC41LDExNC40UzE0LjYsOTIsMTQuNiw2NC41UzM3LDE0LjYsNjQuNSwxNC42eiIgZmlsbD0iI2ZmZmZmZiIvPgogICAgICA8cGF0aCBkPSJtNDIuNyw4NS43YzAuOCwwLjggMS44LDEuMiAyLjksMS4yczIuMS0wLjQgMi45LTEuMmwxNi0xNiAxNiwxNmMwLjgsMC44IDEuOCwxLjIgMi45LDEuMnMyLjEtMC40IDIuOS0xLjJjMS42LTEuNiAxLjYtNC4yIDAtNS44bC0xNi0xNiAxNi0xNmMxLjYtMS42IDEuNi00LjIgMC01LjhzLTQuMi0xLjYtNS44LDBsLTE2LDE2LTE2LTE2Yy0xLjYtMS42LTQuMi0xLjYtNS44LDAtMS42LDEuNi0xLjYsNC4yIDAsNS44bDE2LDE2LTE2LDE2Yy0xLjYsMS42LTEuNiw0LjItMS40MjEwOWUtMTQsNS44eiIgZmlsbD0iI2ZmZmZmZiIvPgogICAgPC9nPgogIDwvZz4KPC9zdmc+Cg==)",
                "background-size": "50px"
            },
            success: {
                color: "#fff",
                "background-color": "#5cb85c",
                "border-color": "#4cae4c",
                "background-image": "url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMTI4cHgiIGhlaWdodD0iMTI4cHgiPgo8Zz4KCTxnPgoJCTxwYXRoIGQ9Ik0zODMuODQxLDE3MS44MzhjLTcuODgxLTguMzEtMjEuMDItOC42NzYtMjkuMzQzLTAuNzc1TDIyMS45ODcsMjk2LjczMmwtNjMuMjA0LTY0Ljg5MyAgICBjLTguMDA1LTguMjEzLTIxLjEzLTguMzkzLTI5LjM1LTAuMzg3Yy04LjIxMyw3Ljk5OC04LjM4NiwyMS4xMzctMC4zODgsMjkuMzVsNzcuNDkyLDc5LjU2MSAgICBjNC4wNjEsNC4xNzIsOS40NTgsNi4yNzUsMTQuODY5LDYuMjc1YzUuMTM0LDAsMTAuMjY4LTEuODk2LDE0LjI4OC01LjY5NGwxNDcuMzczLTEzOS43NjIgICAgQzM5MS4zODMsMTkzLjI5NCwzOTEuNzM1LDE4MC4xNTUsMzgzLjg0MSwxNzEuODM4eiIgZmlsbD0iI2ZmZmZmZiIvPgoJPC9nPgo8L2c+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTI1NiwwQzExNC44NCwwLDAsMTE0Ljg0LDAsMjU2czExNC44NCwyNTYsMjU2LDI1NnMyNTYtMTE0Ljg0LDI1Ni0yNTZTMzk3LjE2LDAsMjU2LDB6IE0yNTYsNDcwLjQ4NyAgICBjLTExOC4yNjUsMC0yMTQuNDg3LTk2LjIxNC0yMTQuNDg3LTIxNC40ODdjMC0xMTguMjY1LDk2LjIyMS0yMTQuNDg3LDIxNC40ODctMjE0LjQ4N2MxMTguMjcyLDAsMjE0LjQ4Nyw5Ni4yMjEsMjE0LjQ4NywyMTQuNDg3ICAgIEM0NzAuNDg3LDM3NC4yNzIsMzc0LjI3Miw0NzAuNDg3LDI1Niw0NzAuNDg3eiIgZmlsbD0iI2ZmZmZmZiIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=)",
                "background-size": "50px"
            },
            info: {
                color: "#fff",
                "background-color": "#31b0d5",
                "border-color": "#269abc",
                "background-image": "url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQzNy42IDQzNy42IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0MzcuNiA0MzcuNjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSIxMjhweCIgaGVpZ2h0PSIxMjhweCI+CjxnPgoJPGc+CgkJPGc+CgkJCTxwYXRoIGQ9Ik0xOTQsMTQyLjhjMC44LDEuNiwxLjYsMy4yLDIuNCw0LjRjMC44LDEuMiwyLDIuNCwyLjgsMy42YzEuMiwxLjIsMi40LDIuNCw0LDMuNmMxLjIsMC44LDIuOCwyLDQuOCwyLjQgICAgIGMxLjYsMC44LDMuMiwxLjIsNS4yLDEuNmMyLDAuNCwzLjYsMC40LDUuMiwwLjRjMS42LDAsMy42LDAsNS4yLTAuNGMxLjYtMC40LDMuMi0wLjgsNC40LTEuNmgwLjRjMS42LTAuOCwzLjItMS42LDQuOC0yLjggICAgIGMxLjItMC44LDIuNC0yLDMuNi0zLjJsMC40LTAuNGMxLjItMS4yLDItMi40LDIuOC0zLjZzMS42LTIuNCwyLTRjMC0wLjQsMC0wLjQsMC40LTAuOGMwLjgtMS42LDEuMi0zLjYsMS42LTUuMiAgICAgYzAuNC0xLjYsMC40LTMuNiwwLjQtNS4yczAtMy42LTAuNC01LjJjLTAuNC0xLjYtMC44LTMuMi0xLjYtNS4yYy0xLjItMi44LTIuOC01LjItNC44LTcuMmMtMC40LTAuNC0wLjQtMC40LTAuOC0wLjggICAgIGMtMS4yLTEuMi0yLjQtMi00LTMuMmMtMS42LTAuOC0yLjgtMS42LTQuNC0yLjRjLTEuNi0wLjgtMy4yLTEuMi00LjgtMS42Yy0yLTAuNC0zLjYtMC40LTUuMi0wLjRjLTEuNiwwLTMuNiwwLTUuMiwwLjQgICAgIGMtMS42LDAuNC0zLjIsMC44LTQuOCwxLjZIMjA4Yy0xLjYsMC44LTMuMiwxLjYtNC40LDIuNGMtMS42LDEuMi0yLjgsMi00LDMuMmMtMS4yLDEuMi0yLjQsMi40LTMuMiwzLjYgICAgIGMtMC44LDEuMi0xLjYsMi44LTIuNCw0LjRjLTAuOCwxLjYtMS4yLDMuMi0xLjYsNC44Yy0wLjQsMi0wLjQsMy42LTAuNCw1LjJjMCwxLjYsMCwzLjYsMC40LDUuMiAgICAgQzE5Mi44LDEzOS42LDE5My42LDE0MS4yLDE5NCwxNDIuOHoiIGZpbGw9IiNmZmZmZmYiLz4KCQkJPHBhdGggZD0iTTI0OS42LDI4OS4yaC05LjJ2LTk4YzAtNS42LTQuNC0xMC40LTEwLjQtMTAuNGgtNDJjLTUuNiwwLTEwLjQsNC40LTEwLjQsMTAuNHYyMS42YzAsNS42LDQuNCwxMC40LDEwLjQsMTAuNGg4LjR2NjYuNCAgICAgSDE4OGMtNS42LDAtMTAuNCw0LjQtMTAuNCwxMC40djIxLjZjMCw1LjYsNC40LDEwLjQsMTAuNCwxMC40aDYxLjZjNS42LDAsMTAuNC00LjQsMTAuNC0xMC40VjMwMCAgICAgQzI2MCwyOTQsMjU1LjIsMjg5LjIsMjQ5LjYsMjg5LjJ6IiBmaWxsPSIjZmZmZmZmIi8+CgkJCTxwYXRoIGQ9Ik0yMTguOCwwQzk4LDAsMCw5OCwwLDIxOC44czk4LDIxOC44LDIxOC44LDIxOC44czIxOC44LTk4LDIxOC44LTIxOC44UzMzOS42LDAsMjE4LjgsMHogTTIxOC44LDQwOC44ICAgICBjLTEwNC44LDAtMTkwLTg1LjItMTkwLTE5MHM4NS4yLTE5MCwxOTAtMTkwczE5MCw4NS4yLDE5MCwxOTBTMzIzLjYsNDA4LjgsMjE4LjgsNDA4Ljh6IiBmaWxsPSIjZmZmZmZmIi8+CgkJPC9nPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=)",
                "background-size": "50px"
            },
            warn: {
                color: "#fff",
                "background-color": "#ec971f",
                "border-color": "#d58512",
                "background-image": "url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDI3Ljk2MyAyNy45NjMiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDI3Ljk2MyAyNy45NjM7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMTI4cHgiIGhlaWdodD0iMTI4cHgiPgo8Zz4KCTxnIGlkPSJjMTI5X2V4Y2xhbWF0aW9uIj4KCQk8cGF0aCBkPSJNMTMuOTgzLDBDNi4yNjEsMCwwLjAwMSw2LjI1OSwwLjAwMSwxMy45NzljMCw3LjcyNCw2LjI2LDEzLjk4NCwxMy45ODIsMTMuOTg0czEzLjk4LTYuMjYxLDEzLjk4LTEzLjk4NCAgICBDMjcuOTYzLDYuMjU5LDIxLjcwNSwwLDEzLjk4MywweiBNMTMuOTgzLDI2LjUzMWMtNi45MzMsMC0xMi41NS01LjYyLTEyLjU1LTEyLjU1M2MwLTYuOTMsNS42MTctMTIuNTQ4LDEyLjU1LTEyLjU0OCAgICBjNi45MzEsMCwxMi41NDksNS42MTgsMTIuNTQ5LDEyLjU0OEMyNi41MzEsMjAuOTExLDIwLjkxMywyNi41MzEsMTMuOTgzLDI2LjUzMXoiIGZpbGw9IiNmZmZmZmYiLz4KCQk8cG9seWdvbiBwb2ludHM9IjE1LjU3OSwxNy4xNTggMTYuMTkxLDQuNTc5IDExLjgwNCw0LjU3OSAxMi40MTQsMTcuMTU4ICAgIiBmaWxsPSIjZmZmZmZmIi8+CgkJPHBhdGggZD0iTTEzLjk5OCwxOC41NDZjLTEuNDcxLDAtMi41LDEuMDI5LTIuNSwyLjUyNmMwLDEuNDQzLDAuOTk5LDIuNTI4LDIuNDQ0LDIuNTI4aDAuMDU2YzEuNDk5LDAsMi40NjktMS4wODUsMi40NjktMi41MjggICAgQzE2LjQ0MSwxOS41NzUsMTUuNDY4LDE4LjU0NiwxMy45OTgsMTguNTQ2eiIgZmlsbD0iI2ZmZmZmZiIvPgoJPC9nPgoJPGcgaWQ9IkNhcGFfMV8yMDdfIj4KCTwvZz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K)",
                "background-size": "50px"
            }
        }
    }), e(function() {
        g(h.css).attr("id", "core-notify"), e(document).on("click", "." + r + "-hidable", function(t) {
            e(this).trigger("notify-hide")
        }), e(document).on("notify-hide", "." + r + "-wrapper", function(t) {
            var n = e(this).data(r);
            n && n.show(!1)
        })
    })
})
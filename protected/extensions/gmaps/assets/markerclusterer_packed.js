(function() {
    var d = true,
        f = null,
        g = false;

    function j(a) {
        return function(b) {
            this[a] = b
        }
    }

    function k(a) {
        return function() {
            return this[a]
        }
    }
    var l;

    function m(a, b, c) {
        this.extend(m, google.maps.OverlayView);
        this.b = a;
        this.a = [];
        this.m = [];
        this.$ = [53, 56, 66, 78, 90];
        this.i = [];
        this.z = g;
        c = c || {};
        this.f = c.gridSize || 60;
        this.V = c.maxZoom || f;
        this.i = c.styles || [];
        this.U = c.imagePath || this.O;
        this.T = c.imageExtension || this.N;
        this.M = d;
        if (c.zoomOnClick != undefined) this.M = c.zoomOnClick;
        this.p = g;
        if (c.averageCenter != undefined) this.p = c.averageCenter;
        n(this);
        this.setMap(a);
        this.I = this.b.getZoom();
        var e = this;
        google.maps.event.addListener(this.b, "zoom_changed", function() {
            var h = e.b.mapTypes[e.b.getMapTypeId()].maxZoom,
                o = e.b.getZoom();
            if (!(o < 0 || o > h))
                if (e.I != o) {
                    e.I = e.b.getZoom();
                    e.k()
                }
        });
        google.maps.event.addListener(this.b, "idle", function() {
            e.h()
        });
        b && b.length && this.B(b, g)
    }
    l = m.prototype;
    //l.O = "http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/images/m";
    l.O = "http://local.optirep/themes/optirep/images/markers/m";
    l.N = "png";
    l.extend = function(a, b) {
        return function(c) {
            for (var e in c.prototype) this.prototype[e] = c.prototype[e];
            return this
        }.apply(a, [b])
    };
    l.onAdd = function() {
        if (!this.z) {
            this.z = d;
            q(this)
        }
    };
    l.draw = function() {};

    function n(a) {
        if (!a.i.length)
            for (var b = 0, c; c = a.$[b]; b++) a.i.push({
                url: a.U + (b + 1) + "." + a.T,
                height: c,
                width: c
            })
    }
    l.w = k("i");
    l.q = k("a");
    l.S = function() {
        return this.a.length
    };
    l.H = function() {
        return this.V || this.b.mapTypes[this.b.getMapTypeId()].maxZoom
    };
    l.F = function(a, b) {
        for (var c = 0, e = a.length, h = e; h !== 0;) {
            h = parseInt(h / 10, 10);
            c++
        }
        c = Math.min(c, b);
        return {
            text: e,
            index: c
        }
    };
    l.Y = j("F");
    l.G = k("F");
    l.B = function(a, b) {
        for (var c = 0, e; e = a[c]; c++) t(this, e);
        b || this.h()
    };

    function t(a, b) {
        b.setVisible(g);
        b.setMap(f);
        b.r = g;
        b.draggable && google.maps.event.addListener(b, "dragend", function() {
            b.r = g;
            a.k();
            a.h()
        });
        a.a.push(b)
    }
    l.o = function(a, b) {
        t(this, a);
        b || this.h()
    };

    function u(a, b) {
        var c = -1;
        if (a.a.indexOf) c = a.a.indexOf(b);
        else
            for (var e = 0, h; h = a.a[e]; e++)
                if (h == b) {
                    c = e;
                    break
                } if (c == -1) return g;
        a.a.splice(c, 1);
        b.setVisible(g);
        b.setMap(f);
        return d
    }
    l.W = function(a, b) {
        var c = u(this, a);
        if (!b && c) {
            this.k();
            this.h();
            return d
        } else return g
    };
    l.X = function(a, b) {
        for (var c = g, e = 0, h; h = a[e]; e++) {
            h = u(this, h);
            c = c || h
        }
        if (!b && c) {
            this.k();
            this.h();
            return d
        }
    };
    l.R = function() {
        return this.m.length
    };
    l.getMap = k("b");
    l.setMap = j("b");
    l.v = k("f");
    l.Z = j("f");
    l.u = function(a) {
        var b = this.getProjection(),
            c = new google.maps.LatLng(a.getNorthEast().lat(), a.getNorthEast().lng()),
            e = new google.maps.LatLng(a.getSouthWest().lat(), a.getSouthWest().lng());
        c = b.fromLatLngToDivPixel(c);
        c.x += this.f;
        c.y -= this.f;
        e = b.fromLatLngToDivPixel(e);
        e.x -= this.f;
        e.y += this.f;
        c = b.fromDivPixelToLatLng(c);
        b = b.fromDivPixelToLatLng(e);
        a.extend(c);
        a.extend(b);
        return a
    };
    l.P = function() {
        this.k();
        this.a = []
    };
    l.k = function() {
        for (var a = 0, b; b = this.m[a]; a++) b.remove();
        for (a = 0; b = this.a[a]; a++) {
            b.r = g;
            b.setMap(f);
            b.setVisible(g)
        }
        this.m = []
    };
    l.h = function() {
        q(this)
    };

    function q(a) {
        if (a.z)
            for (var b = a.u(new google.maps.LatLngBounds(a.b.getBounds().getSouthWest(), a.b.getBounds().getNorthEast())), c = 0, e; e = a.a[c]; c++)
                if (!e.r && b.contains(e.getPosition())) {
                    var h = a;
                    e = e;
                    for (var o = 4E4, r = f, x = 0, p = void 0; p = h.m[x]; x++) {
                        var i = p.getCenter();
                        if (i) {
                            i = i;
                            var s = e.getPosition();
                            if (!i || !s) i = 0;
                            else {
                                var y = (s.lat() - i.lat()) * Math.PI / 180,
                                    z = (s.lng() - i.lng()) * Math.PI / 180;
                                i = Math.sin(y / 2) * Math.sin(y / 2) + Math.cos(i.lat() * Math.PI / 180) * Math.cos(s.lat() * Math.PI / 180) * Math.sin(z / 2) * Math.sin(z / 2);
                                i = 6371 * 2 * Math.atan2(Math.sqrt(i), Math.sqrt(1 - i))
                            }
                            if (i < o) {
                                o = i;
                                r = p
                            }
                        }
                    }
                    if (r && r.D.contains(e.getPosition())) r.o(e);
                    else {
                        p = new v(h);
                        p.o(e);
                        h.m.push(p)
                    }
                }
    }

    function v(a) {
        this.j = a;
        this.b = a.getMap();
        this.f = a.v();
        this.p = a.p;
        this.d = f;
        this.a = [];
        this.D = f;
        this.l = new w(this, a.w(), a.v())
    }
    l = v.prototype;
    l.o = function(a) {
        var b;
        a: if (this.a.indexOf) b = this.a.indexOf(a) != -1;
            else {
                b = 0;
                for (var c; c = this.a[b]; b++)
                    if (c == a) {
                        b = d;
                        break a
                    }
                b = g
            }
        if (b) return g;
        if (this.d) {
            if (this.p) {
                c = this.a.length + 1;
                b = (this.d.lat() * (c - 1) + a.getPosition().lat()) / c;
                c = (this.d.lng() * (c - 1) + a.getPosition().lng()) / c;
                this.d = new google.maps.LatLng(b, c);
                A(this)
            }
        } else {
            this.d = a.getPosition();
            A(this)
        }
        if (this.a.length == 0) {
            a.setMap(this.b);
            a.setVisible(d)
        } else if (this.a.length == 1) {
            this.a[0].setMap(f);
            this.a[0].setVisible(g)
        }
        a.r = d;
        this.a.push(a);
        if (this.b.getZoom() > this.j.H())
            for (a = 0; b = this.a[a]; a++) {
                b.setMap(this.b);
                b.setVisible(d)
            } else if (this.a.length < 2) B(this.l);
            else {
                b = this.j.G()(this.a, this.j.w().length);
                this.l.setCenter(this.d);
                a = this.l;
                a.A = b;
                a.ca = b.text;
                a.aa = b.index;
                if (a.c) a.c.innerHTML = b.text;
                b = Math.max(0, a.A.index - 1);
                b = Math.min(a.i.length - 1, b);
                b = a.i[b];
                a.L = b.url;
                a.g = b.height;
                a.n = b.width;
                a.J = b.textColor;
                a.e = b.anchor;
                a.K = b.textSize;
                a.C = b.backgroundPosition;
                this.l.show()
            }
        return d
    };
    l.getBounds = function() {
        for (var a = new google.maps.LatLngBounds(this.d, this.d), b = this.q(), c = 0, e; e = b[c]; c++) a.extend(e.getPosition());
        return a
    };
    l.remove = function() {
        this.l.remove();
        this.a.length = 0;
        delete this.a
    };
    l.Q = function() {
        return this.a.length
    };
    l.q = k("a");
    l.getCenter = k("d");

    function A(a) {
        a.D = a.j.u(new google.maps.LatLngBounds(a.d, a.d))
    }
    l.getMap = k("b");

    function w(a, b, c) {
        a.j.extend(w, google.maps.OverlayView);
        this.i = b;
        this.ba = c || 0;
        this.t = a;
        this.d = f;
        this.b = a.getMap();
        this.A = this.c = f;
        this.s = g;
        this.setMap(this.b)
    }
    l = w.prototype;
    l.onAdd = function() {
        this.c = document.createElement("DIV");
        if (this.s) {
            this.c.style.cssText = C(this, D(this, this.d));
            this.c.innerHTML = this.A.text
        }
        this.getPanes().overlayImage.appendChild(this.c);
        var a = this;
        google.maps.event.addDomListener(this.c, "click", function() {
            var b = a.t.j;
            google.maps.event.trigger(b, "clusterclick", a.t);
            b.M && a.b.fitBounds(a.t.getBounds())
        })
    };

    function D(a, b) {
        var c = a.getProjection().fromLatLngToDivPixel(b);
        c.x -= parseInt(a.n / 2, 10);
        c.y -= parseInt(a.g / 2, 10);
        return c
    }
    l.draw = function() {
        if (this.s) {
            var a = D(this, this.d);
            this.c.style.top = a.y + "px";
            this.c.style.left = a.x + "px"
        }
    };

    function B(a) {
        if (a.c) a.c.style.display = "none";
        a.s = g
    }
    l.show = function() {
        if (this.c) {
            this.c.style.cssText = C(this, D(this, this.d));
            this.c.style.display = ""
        }
        this.s = d
    };
    l.remove = function() {
        this.setMap(f)
    };
    l.onRemove = function() {
        if (this.c && this.c.parentNode) {
            B(this);
            this.c.parentNode.removeChild(this.c);
            this.c = f
        }
    };
    l.setCenter = j("d");

    function C(a, b) {
        var c = [];
        if (document.all) c.push('filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="' + a.L + '");');
        else {
            c.push("background-image:url(" + a.L + ");");
            c.push("background-position:" + (a.C ? a.C : "0 0") + ";")
        }
        if (typeof a.e === "object") {
            typeof a.e[0] === "number" && a.e[0] > 0 && a.e[0] < a.g ? c.push("height:" + (a.g - a.e[0]) + "px; padding-top:" + a.e[0] + "px;") : c.push("height:" + a.g + "px; line-height:" + a.g + "px;");
            typeof a.e[1] === "number" && a.e[1] > 0 && a.e[1] < a.n ? c.push("width:" + (a.n - a.e[1]) + "px; padding-left:" + a.e[1] + "px;") : c.push("width:" + a.n + "px; text-align:center;")
        } else c.push("height:" + a.g + "px; line-height:" + a.g + "px; width:" + a.n + "px; text-align:center;");
        c.push("cursor:pointer; top:" + b.y + "px; left:" + b.x + "px; color:" + (a.J ? a.J : "black") + "; position:absolute; font-size:" + (a.K ? a.K : 11) + "px; font-family:Arial,sans-serif; font-weight:bold");
        return c.join("")
    }
    window.MarkerClusterer = m;
    m.prototype.addMarker = m.prototype.o;
    m.prototype.addMarkers = m.prototype.B;
    m.prototype.clearMarkers = m.prototype.P;
    m.prototype.getCalculator = m.prototype.G;
    m.prototype.getGridSize = m.prototype.v;
    m.prototype.getExtendedBounds = m.prototype.u;
    m.prototype.getMap = m.prototype.getMap;
    m.prototype.getMarkers = m.prototype.q;
    m.prototype.getMaxZoom = m.prototype.H;
    m.prototype.getStyles = m.prototype.w;
    m.prototype.getTotalClusters = m.prototype.R;
    m.prototype.getTotalMarkers = m.prototype.S;
    m.prototype.redraw = m.prototype.h;
    m.prototype.removeMarker = m.prototype.W;
    m.prototype.removeMarkers = m.prototype.X;
    m.prototype.resetViewport = m.prototype.k;
    m.prototype.setCalculator = m.prototype.Y;
    m.prototype.setGridSize = m.prototype.Z;
    m.prototype.onAdd = m.prototype.onAdd;
    m.prototype.draw = m.prototype.draw;
    v.prototype.getCenter = v.prototype.getCenter;
    v.prototype.getSize = v.prototype.Q;
    v.prototype.getMarkers = v.prototype.q;
    w.prototype.onAdd = w.prototype.onAdd;
    w.prototype.draw = w.prototype.draw;
    w.prototype.onRemove = w.prototype.onRemove
})();
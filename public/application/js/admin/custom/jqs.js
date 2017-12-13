(function() {

    var matched, browser,mobile;
var mobile_test = (navigator.userAgent||navigator.vendor||window.opera);
// Use of jQuery.browser is frowned upon.
// More details: http://api.jquery.com/jQuery.browser
// jQuery.uaMatch maintained for back-compat
    jQuery.uaMatch = function( ua ) {
        ua = ua.toLowerCase();

        var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
            /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
            /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
            /(msie) ([\w.]+)/.exec( ua ) ||
            ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
            [];
        var is_mobile =/(android|bb\d+|meego).+mobile|android|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(mobile_test)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(mobile_test.substr(0,4));    
        return {
            browser: match[ 1 ] || "",
            version: match[ 2 ] || "0",
            mobile: is_mobile
        };
    };

    matched = jQuery.uaMatch( navigator.userAgent );
    browser = {};
    mobile = {};

    if ( matched.browser ) {
        browser[ matched.browser ] = true;
        browser.version = matched.version;
        browser.mobile = matched.mobile;
    }
    

// Chrome is Webkit, but Webkit is also Safari.

    if ( browser.chrome ) {
        browser.webkit = true;
    } else if ( browser.webkit ) {
        browser.safari = true;
    }

    jQuery.browser = browser;

    jQuery.sub = function() {
        function jQuerySub( selector, context ) {
            return new jQuerySub.fn.init( selector, context );
        }
        jQuery.extend( true, jQuerySub, this );
        jQuerySub.superclass = this;
        jQuerySub.fn = jQuerySub.prototype = this();
        jQuerySub.fn.constructor = jQuerySub;
        jQuerySub.sub = this.sub;
        jQuerySub.fn.init = function init( selector, context ) {
            if ( context && context instanceof jQuery && !(context instanceof jQuerySub) ) {
                context = jQuerySub( context );
            }

            return jQuery.fn.init.call( this, selector, context, rootjQuerySub );
        };
        jQuerySub.fn.init.prototype = jQuerySub.fn;
        var rootjQuerySub = jQuerySub(document);
        return jQuerySub;
    };

})();

/*
 * 
 *  Inview min jquery
 */
(function(d){var p={},e,a,h=document,i=window,f=h.documentElement,j=d.expando;d.event.special.inview={add:function(a){p[a.guid+"-"+this[j]]={data:a,$element:d(this)}},remove:function(a){try{delete p[a.guid+"-"+this[j]]}catch(d){}}};d(i).bind("scroll resize",function(){e=a=null});!f.addEventListener&&f.attachEvent&&f.attachEvent("onfocusin",function(){a=null});setInterval(function(){var k=d(),j,n=0;d.each(p,function(a,b){var c=b.data.selector,d=b.$element;k=k.add(c?d.find(c):d)});if(j=k.length){var b;
if(!(b=e)){var g={height:i.innerHeight,width:i.innerWidth};if(!g.height&&((b=h.compatMode)||!d.support.boxModel))b="CSS1Compat"===b?f:h.body,g={height:b.clientHeight,width:b.clientWidth};b=g}e=b;for(a=a||{top:i.pageYOffset||f.scrollTop||h.body.scrollTop,left:i.pageXOffset||f.scrollLeft||h.body.scrollLeft};n<j;n++)if(d.contains(f,k[n])){b=d(k[n]);var l=b.height(),m=b.width(),c=b.offset(),g=b.data("inview");if(!a||!e)break;c.top+l>a.top&&c.top<a.top+e.height&&c.left+m>a.left&&c.left<a.left+e.width?
(m=a.left>c.left?"right":a.left+e.width<c.left+m?"left":"both",l=a.top>c.top?"bottom":a.top+e.height<c.top+l?"top":"both",c=m+"-"+l,(!g||g!==c)&&b.data("inview",c).trigger("inview",[!0,m,l])):g&&b.data("inview",!1).trigger("inview",[!1])}}},250)})(jQuery);


/*
 * 
 * page alert and floating alert
 * 
 */

(function (n) {
    "use strict";
    var t, e, i = {},
        a = !1;
    window.ritz = {
        container: n("#container"),
        contentContainer: n("#content-container"),
        window: n(window),
        body: n("body"),
        bodyHtml: n("body, html"),
        document: n(document),
        randomInt: function(n, t) {
            return Math.floor(Math.random() * (t - n + 1) + n)
        },
        transition: function() {
            var n = document.body || document.documentElement,
                t = n.style,
                e = void 0 !== t.transition || void 0 !== t.WebkitTransition;
            return e
        }()
    };    
    n.ritzNoty = function(o) {
        {
            var s, l = {
                    type: "primary",
                    icon: "",
                    title: "",
                    message: "",
                    closeBtn: !0,
                    container: "page",
                    floating: {
                        position: "top-right",
                        animationIn: "jellyIn",
                        animationOut: "fadeOut"
                    },
                    html: null,
                    focus: !0,
                    timer: 0
                },
                r = n.extend({}, l, o),
                c = n('<div class="alert-wrap"></div>'),
                f = function() {
                    var n = "";
                    return o && o.icon && (n = '<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon"><i class="' + r.icon + '"></i></span></div>'), n
                },
                d = function() {
                    var n = r.closeBtn ? '<button class="close" type="button"><i class="fa fa-times-circle"></i></button>' : "",
                        t = '<div class="alert alert-' + r.type + '" role="alert">' + n + '<div class="media">';
                    return r.html ? t + r.html + "</div></div>" : t + f() + '<div class="media-body"><h4 class="alert-title">' + r.title + '</h4><p class="alert-message">' + r.message + "</p></div></div>"
                }(),
                u = function() {
                    return "floating" === r.container && r.floating.animationOut && (c.removeClass(r.floating.animationIn).addClass(r.floating.animationOut), ritz.transition || c.remove()), c.removeClass("in").on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(n) {
                        "max-height" == n.originalEvent.propertyName && c.remove()
                    }), clearInterval(s), null
                },
                v = function(n) {
                    ritz.bodyHtml.animate({
                        scrollTop: n
                    }, 300, function() {
                        c.addClass("in")
                    })
                };
            ! function() {
                if ("page" === r.container) t || (t = n('<div id="page-alert"></div>'), ritz.contentContainer.prepend(t)), e = t, r.focus && v(0);
                else if ("floating" === r.container) i[r.floating.position] || (i[r.floating.position] = n('<div id="floating-' + r.floating.position + '" class="floating-container"></div>'), ritz.container.append(i[r.floating.position])), e = i[r.floating.position], r.floating.animationIn && c.addClass("in animated " + r.floating.animationIn), r.focus = !1;
                else {
                    var o = n(r.container),
                        s = o.children(".panel-alert"),
                        l = o.children(".panel-heading");
                    if (!o.length) return a = !1, !1;
                    s.length ? e = s : (e = n('<div class="panel-alert"></div>'), l.length ? l.after(e) : o.prepend(e)), r.focus && v(o.offset().top - 30)
                }
                return a = !0, !1
            }()
        }
        if (a && (e.append(c.html(d)), c.find('[data-dismiss="noty"]').one("click", u), r.closeBtn && c.find(".close").one("click", u), r.timer > 0 && (s = setInterval(u, r.timer)), !r.focus)) var m = setInterval(function() {
            c.addClass("in"), clearInterval(m)
        }, 200)
    }
}(jQuery));


/*
 * rtloady to lazy load images when page get loaded and page behaviour becomes faster
 */

(function ($) {
    $.fn.rtloady = function (options) {
        var settings = 
            $.extend({}, {
                delay: 1000
            }, options);
        var mainthis = this;    
        function loadImages()
        {
            $(mainthis).each(function(){
                var _this = this;
                var orig_src = $(this).attr("data-src");
                var date = new Date();
                $(this).append("<img class='dep_loader' src='"+orig_src+"?t="+date.getTime()+"' style='display:none;'>");
            });

            $(".dep_loader").load(function(){
                var parent = $(this).parent();
                if(parent.length == 0)
                    return;
                var src = $(this).attr("src");
                $(parent).hide().fadeIn(1000);
                $(parent).attr("src",src).show(1000);
                $(this).remove();
                $(parent).removeClass("loading-cl");
            });
        }
        setTimeout(function(){
            return loadImages();
        },settings.delay);

   };
}(jQuery));
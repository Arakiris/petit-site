!function(e){var t={};function n(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{configurable:!1,enumerable:!0,get:o})},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=185)}({185:function(e,t,n){e.exports=n(186)},186:function(e,t){document.querySelectorAll(".news__single").forEach(function(e){var t=e.querySelector(".news__button");e.offsetHeight>140?t.addEventListener("click",function(e){e.preventDefault();var t=void 0,n=void 0,o=0;(n=(t=e.target.parentNode).parentNode).querySelectorAll("p:not(.news__read-more)").forEach(function(e){o+=e.offsetHeight}),console.log(o.offsetHeight),n.style.transitionProperty="height, margin, padding",n.style.transitionDuration=".5s",n.style.height=n.offsetHeight+"px",n.offsetHeight,n.style.maxHeight="none",n.style.height=o+"px",t.style.display="none"},!1):(console.log(t.parentNode),t.parentNode.style.display="none")})}});
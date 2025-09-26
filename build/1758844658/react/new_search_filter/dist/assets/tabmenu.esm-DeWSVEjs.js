import{T as Pe,r as s,U as Te,V as we,W as Oe,ab as Ee,a1 as N,a6 as c,ac as _e,a7 as Ne,a3 as ke,a8 as De}from"./vendor-B1il49z_.js";import"./gmaps-BDODJA70.js";function I(t){"@babel/helpers - typeof";return I=typeof Symbol=="function"&&typeof Symbol.iterator=="symbol"?function(a){return typeof a}:function(a){return a&&typeof Symbol=="function"&&a.constructor===Symbol&&a!==Symbol.prototype?"symbol":typeof a},I(t)}function je(t,a){if(I(t)!=="object"||t===null)return t;var r=t[Symbol.toPrimitive];if(r!==void 0){var l=r.call(t,a||"default");if(I(l)!=="object")return l;throw new TypeError("@@toPrimitive must return a primitive value.")}return(a==="string"?String:Number)(t)}function Ce(t){var a=je(t,"string");return I(a)==="symbol"?a:String(a)}function Re(t,a,r){return a=Ce(a),a in t?Object.defineProperty(t,a,{value:r,enumerable:!0,configurable:!0,writable:!0}):t[a]=r,t}function Ae(t){if(Array.isArray(t))return t}function Me(t,a){var r=t==null?null:typeof Symbol<"u"&&t[Symbol.iterator]||t["@@iterator"];if(r!=null){var l,i,h,d,m=[],b=!0,S=!1;try{if(h=(r=r.call(t)).next,a===0){if(Object(r)!==r)return;b=!1}else for(;!(b=(l=h.call(r)).done)&&(m.push(l.value),m.length!==a);b=!0);}catch(x){S=!0,i=x}finally{try{if(!b&&r.return!=null&&(d=r.return(),Object(d)!==d))return}finally{if(S)throw i}}return m}}function F(t,a){(a==null||a>t.length)&&(a=t.length);for(var r=0,l=new Array(a);r<a;r++)l[r]=t[r];return l}function Le(t,a){if(t){if(typeof t=="string")return F(t,a);var r=Object.prototype.toString.call(t).slice(8,-1);if(r==="Object"&&t.constructor&&(r=t.constructor.name),r==="Map"||r==="Set")return Array.from(t);if(r==="Arguments"||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r))return F(t,a)}}function Ke(){throw new TypeError(`Invalid attempt to destructure non-iterable instance.
In order to be iterable, non-array objects must have a [Symbol.iterator]() method.`)}function $(t,a){return Ae(t)||Me(t,a)||Le(t,a)||Ke()}var Be={icon:function(a){var r=a._icon;return N("p-menuitem-icon",r)},label:"p-menuitem-text",action:"p-menuitem-link",menuitem:function(a){var r=a._className,l=a.active,i=a.disabled;return N("p-tabmenuitem",{"p-highlight":l,"p-disabled":i},r)},inkbar:"p-tabmenu-ink-bar",menu:"p-tabmenu-nav p-reset",root:"p-tabmenu p-component"},Ue=`
@layer primereact {
    .p-tabmenu {
        overflow-x: auto;
    }

    .p-tabmenu-nav {
        display: flex;
        margin: 0;
        padding: 0;
        list-style-type: none;
        flex-wrap: nowrap;
    }

    .p-tabmenu-nav a {
        cursor: pointer;
        user-select: none;
        display: flex;
        align-items: center;
        position: relative;
        text-decoration: none;
        text-decoration: none;
        overflow: hidden;
    }

    .p-tabmenu-nav a:focus {
        z-index: 1;
    }

    .p-tabmenu-nav .p-menuitem-text {
        line-height: 1;
    }

    .p-tabmenu-ink-bar {
        display: none;
        z-index: 1;
    }

    .p-tabmenu::-webkit-scrollbar {
        display: none;
    }
}
`,_=Pe.extend({defaultProps:{__TYPE:"TabMenu",id:null,model:null,activeIndex:0,ariaLabel:null,ariaLabelledBy:null,style:null,className:null,onTabChange:null,children:void 0},css:{classes:Be,styles:Ue}});function H(t,a){var r=Object.keys(t);if(Object.getOwnPropertySymbols){var l=Object.getOwnPropertySymbols(t);a&&(l=l.filter(function(i){return Object.getOwnPropertyDescriptor(t,i).enumerable})),r.push.apply(r,l)}return r}function W(t){for(var a=1;a<arguments.length;a++){var r=arguments[a]!=null?arguments[a]:{};a%2?H(Object(r),!0).forEach(function(l){Re(t,l,r[l])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(r)):H(Object(r)).forEach(function(l){Object.defineProperty(t,l,Object.getOwnPropertyDescriptor(r,l))})}return t}var Fe=s.memo(s.forwardRef(function(t,a){var r=Te(),l=s.useContext(we),i=_.getProps(t,l),h=s.useState(i.id),d=$(h,2),m=d[0],b=d[1],S=s.useState(i.activeIndex),x=$(S,2),z=x[0],J=x[1],A=s.useRef(null),v=s.useRef(null),f=s.useRef(null),X=s.useRef({}),M=i.onTabChange?i.activeIndex:z,L={props:i,state:{id:m,activeIndex:M}},k=_.setMetaData(W({},L)),P=k.ptm,p=k.cx,q=k.isUnstyled,T=function(e,n,u){return P(e,{parent:L,context:{item:n,index:u}})};Oe(_.css.styles,q,{name:"tabmenu"});var D=function(e,n,u){if(n.disabled){e.preventDefault();return}n.command&&n.command({originalEvent:e,item:n}),i.onTabChange?i.onTabChange({originalEvent:e,value:n,index:u}):J(u),n.url||(e.preventDefault(),e.stopPropagation())},V=function(e){return e===(M||0)},Y=function(){if(i.model){for(var e=f.current.children,n=!1,u=0;u<e.length;u++){var y=e[u];c.getAttribute(y,"data-p-highlight")&&(v.current.style.width=c.getWidth(y)+"px",v.current.style.left=c.getOffset(y).left-c.getOffset(f.current).left+"px",n=!0)}n||(v.current.style.width="0px",v.current.style.left="0px")}};Ee(function(){m||b(_e())}),s.useImperativeHandle(a,function(){return{props:i,getElement:function(){return A.current}}}),s.useEffect(function(){Y()});var G=function(e,n,u){switch(e.code){case"ArrowRight":Q(e.target),e.preventDefault();break;case"ArrowLeft":Z(e.target),e.preventDefault();break;case"Home":ee(e.target),e.preventDefault();break;case"End":te(e.target),e.preventDefault();break;case"Space":case"Enter":case"NumpadEnter":D(e,n,u),e.preventDefault();break;case"Tab":le();break}},Q=function(e){var n=ne(e);n&&w(e,n)},Z=function(e){var n=ae(e);n&&w(e,n)},ee=function(e){var n=re();n&&w(e,n)},te=function(e){var n=ie();n&&w(e,n)},ne=function o(e){var n=e.parentElement.nextElementSibling;return n?c.getAttribute(n,"data-p-disabled")===!0?o(n.children[0]):n.children[0]:null},ae=function o(e){var n=e.parentElement.previousElementSibling;return n?c.getAttribute(n,"data-p-disabled")===!0?o(n.children[0]):n.children[0]:null},re=function(){var e=c.findSingle(f.current,'[data-pc-section="menuitem"][data-p-disabled="false"]');return e?e.children[0]:null},ie=function(){var e=c.find(f.current,'[data-pc-section="menuitem"][data-p-disabled="false"]');return e?e[e.length-1].children[0]:null},w=function(e,n){e.tabIndex="-1",n.tabIndex="0",n.focus()},le=function(){var e=c.findSingle(f.current,'[data-pc-section="menuitem"][data-p-disabled="false"][data-p-highlight="true"]'),n=c.findSingle(f.current,'[data-pc-section="action"][tabindex="0"]');n!==e.children[0]&&(e&&(e.children[0].tabIndex="0"),n.tabIndex="-1")},oe=function(e,n){if(e.visible===!1)return null;var u=e.className,y=e.style,O=e.disabled,j=e.icon,C=e.label,K=e.template,pe=e.url,de=e.target,B=e.id||m+"_"+n,E=V(n),be=N("p-menuitem-icon",j),ve=r({className:p("icon",{_icon:j})},T("icon",e,n)),ye=Ne.getJSXIcon(j,W({},ve),{props:i}),ge=r({className:p("label")},T("label",e,n)),Ie=C&&s.createElement("span",ge,C),he=r({href:pe||"#",role:"menuitem","aria-label":C,tabIndex:E?"0":"-1",className:p("action"),target:de,onClick:function(g){return D(g,e,n)}},T("action",e,n)),R=s.createElement("a",he,ye,Ie,s.createElement(De,null));if(K){var Se={onClick:function(g){return D(g,e,n)},className:"p-menuitem-link",labelClassName:"p-menuitem-text",iconClassName:be,element:R,props:i,active:E,index:n,disabled:O};R=ke.getJSXElement(K,e,Se)}var xe=r({ref:X.current["tab_".concat(n)],id:B,key:B,onKeyDown:function(g){return G(g,e,n)},className:p("menuitem",{_className:u,active:E,disabled:O}),style:y,role:"presentation","data-p-highlight":E,"data-p-disabled":O||!1,"aria-disabled":O},T("menuitem",e,n));return s.createElement("li",xe,R)},se=function(){return i.model.map(oe)};if(i.model){var ue=se(),ce=r({ref:v,role:"none",className:p("inkbar")},P("inkbar")),me=r({ref:f,"aria-label":i.ariaLabel,"aria-labelledby":i.ariaLabelledBy,className:p("menu"),role:"menubar"},P("menu")),fe=r({id:i.id,ref:A,className:N(i.className,p("root")),style:i.style},_.getOtherProps(i),P("root"));return s.createElement("div",fe,s.createElement("ul",me,ue,s.createElement("li",ce)))}return null}));Fe.displayName="TabMenu";export{Fe as TabMenu};

import{aG as h,U as M,u as f}from"./index-C7PaGv0p.js";import"./vendor-B1il49z_.js";const w=({amount:e,position:a,AdvancedMarkerElement:c})=>{const t=document.createElement("div");t.className="MarkerClustererElement";const s=Math.min(e+26,50);return t.style.height=s+10+"px",t.style.width=s+10+"px",t.innerHTML=`
    <div 
      style="width: ${s}px; height: ${s}px;"
    >
      ${e}
    </div>
    `,new c({position:a,content:t})},C=async({markers:e,map:a,markerGrouping:c=!1})=>{const{AdvancedMarkerElement:t}=await google.maps.importLibrary("marker"),{MarkerClusterer:s,SuperClusterAlgorithm:l}=await h();return new s({markers:e,map:a,algorithm:new l({maxZoom:c&&14,radius:120}),renderer:{render:({markers:m,position:i})=>w({position:i,amount:m?.length||0,AdvancedMarkerElement:t})}})};function x({properties:e,AdvancedMarkerElement:a,handleClick:c,favoriteIcon:t,favoriteCTA:s,shareCTA:l,t:o,attachToMap:m=!1,map:i}){const r=e[0],k=`${r.lat},${r.lng}`,n=document.createElement("div");if(n.className="ms-sf-richmarker",n.id=k,n.title=e.map(({mls_num:u})=>u).join(","),e.length>1)n.innerHTML=`<span class="ms-sf-price">${e.length} ${o("Units")}</span>`;else{const g=r.mls_status===2?r.price_sold||0:r.price,p=r?.reduced_price!==null&&!isNaN(r?.reduced_price)?r?.reduced_price:0;n.innerHTML=`
      <span class="ms-sf-price">
        ${M.format(g)}
        ${p?`<i class="sf-icon-arrow-back ${p<0?"-down":"-up"}"></i>`:""}
      </span>`}const d=new a({position:{lat:Number(r.lat),lng:Number(r.lng)},content:n,...m&&i?{map:i}:{}});return d.addListener("click",()=>f({properties:e,favoriteIcon:t,favoriteCTA:s,shareCTA:l,handleClick:c,t:o})),d}export{w as M,C as P,x as a};

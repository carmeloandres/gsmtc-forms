(()=>{"use strict";var e,t={837:()=>{const e=window.wp.blocks,t=window.React,n=window.wp.i18n,s=window.wp.element,a=window.wp.blockEditor,r=window.wp.components;(0,e.registerBlockType)("gsmtc-forms/form",{edit:function({attributes:e,setAttributes:o}){const{id:l,name:i,response:m,sendmessage:c,failmessage:u,successmessage:d}=e,f=(0,a.useBlockProps)(),[g,p]=(0,s.useState)(!1),b=()=>{p(!1)};return(0,s.useEffect)((()=>{if("0"==l){let e=Math.trunc(Date.now()/1e3);o({id:e.toString()}),p(!0)}let e=Array.from(document.getElementsByClassName("editor-post-publish-button"));e.length>0&&e[0].addEventListener("click",b)}),[]),(0,t.createElement)(t.Fragment,null,(0,t.createElement)(a.InspectorControls,null,(0,t.createElement)(r.Panel,null,(0,t.createElement)(r.PanelBody,{title:(0,n.__)("Form information ","gsmtc-forms"),initialOpen:!0},(0,t.createElement)(r.TextControl,{label:(0,n.__)("Form name","gsmtc-forms"),value:i,onChange:e=>o({name:e})}),(0,t.createElement)(r.Button,{disabled:g,onClick:()=>{let e=Math.trunc(Date.now()/1e3);o({id:e.toString()}),p(!0)},style:{backgroundColor:"#0073aa",color:"#fff",borderRadius:"4px",padding:"8px 16px",fontSize:"14px"}},(0,n.__)("Set as new Form","gsmtc-forms")))),(0,t.createElement)(r.Panel,null,(0,t.createElement)(r.PanelBody,{title:(0,n.__)("Form submit response ","gsmtc-forms"),initialOpen:!0},(0,t.createElement)(r.RadioControl,{label:(0,n.__)("Select response action after success submit","gsmtc-forms"),help:(0,n.__)("Chose what actión to perform with form after a success submit","gsmtf-forms"),selected:m,options:[{label:"Nothing",value:"nothing"},{label:"Clean",value:"clean"},{label:"Hide",value:"hide"}],onChange:e=>o({response:e})}),(0,t.createElement)(r.TextControl,{label:(0,n.__)("Message when sending information","gsmtc-forms"),value:c,onChange:e=>o({sendmessage:e})}),(0,t.createElement)(r.TextControl,{label:(0,n.__)("Message when the sending of information fails","gsmtc-forms"),value:u,onChange:e=>o({failmessage:e})}),(0,t.createElement)(r.TextControl,{label:(0,n.__)("Message when the sending of information is successful","gsmtc-forms"),value:d,onChange:e=>o({successmessage:e})})))),(0,t.createElement)("div",null),(0,t.createElement)("form",{...f,id:l,name:i},(0,t.createElement)("input",{type:"submit",value:"To prevent submit at press enter",hidden:!0,disabled:!0}),(0,t.createElement)(a.InnerBlocks,null)))},save:function({attributes:e}){const{id:n,name:s,response:r,sendmessage:o,failmessage:l,successmessage:i}=e,m=a.useBlockProps.save();return(0,t.createElement)(t.Fragment,null,(0,t.createElement)("form",{...m,id:n,name:s,pattern:"^[a-zA-Z0-9s'\"?!]+$","data-response":r,"data-send-message":o,"data-fail-message":l,"data-success-message":i},(0,t.createElement)("input",{type:"submit",value:"To prevent submit at press enter",hidden:!0,disabled:!0}),(0,t.createElement)(a.InnerBlocks.Content,null)))}})}},n={};function s(e){var a=n[e];if(void 0!==a)return a.exports;var r=n[e]={exports:{}};return t[e](r,r.exports,s),r.exports}s.m=t,e=[],s.O=(t,n,a,r)=>{if(!n){var o=1/0;for(c=0;c<e.length;c++){for(var[n,a,r]=e[c],l=!0,i=0;i<n.length;i++)(!1&r||o>=r)&&Object.keys(s.O).every((e=>s.O[e](n[i])))?n.splice(i--,1):(l=!1,r<o&&(o=r));if(l){e.splice(c--,1);var m=a();void 0!==m&&(t=m)}}return t}r=r||0;for(var c=e.length;c>0&&e[c-1][2]>r;c--)e[c]=e[c-1];e[c]=[n,a,r]},s.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={826:0,431:0};s.O.j=t=>0===e[t];var t=(t,n)=>{var a,r,[o,l,i]=n,m=0;if(o.some((t=>0!==e[t]))){for(a in l)s.o(l,a)&&(s.m[a]=l[a]);if(i)var c=i(s)}for(t&&t(n);m<o.length;m++)r=o[m],s.o(e,r)&&e[r]&&e[r][0](),e[r]=0;return s.O(c)},n=globalThis.webpackChunkgsmtc_forms_pro=globalThis.webpackChunkgsmtc_forms_pro||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))})();var a=s.O(void 0,[431],(()=>s(837)));a=s.O(a)})();
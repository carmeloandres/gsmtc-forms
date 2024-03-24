(()=>{"use strict";const e=window.wp.blocks,t=window.React,n=window.wp.i18n,o=window.wp.blockEditor,r=window.wp.components;(0,e.registerBlockType)("gsmtc-forms/textarea",{edit:function({attributes:e,setAttributes:l}){const{cols:a,name:s,placeholder:c,required:m,rows:i}=e,u=(0,o.useBlockProps)();return(0,t.createElement)(t.Fragment,null,(0,t.createElement)(o.InspectorControls,null,(0,t.createElement)(r.Panel,null,(0,t.createElement)(r.PanelBody,{title:(0,n.__)("Input text information ","gsmtc-forms"),initialOpen:!0},(0,t.createElement)(r.TextControl,{label:(0,n.__)("Input name","gsmtc-forms"),value:s,onChange:e=>l({name:e})}),(0,t.createElement)(r.TextControl,{label:(0,n.__)("Placeholder","gsmtc-forms"),value:c,onChange:e=>l({placeholder:e})}),(0,t.createElement)(r.RangeControl,{label:(0,n.__)("Rows number","gsmtc-forms"),value:i,onChange:e=>l({rows:e}),min:1,max:50}),(0,t.createElement)(r.RangeControl,{label:(0,n.__)("Cols number","gsmtc-forms"),value:a,onChange:e=>l({cols:e}),min:1,max:100}),(0,t.createElement)(r.ToggleControl,{label:(0,n.__)("Required","gsmtc-forms"),checked:m,onChange:e=>l({required:e})})))),(0,t.createElement)("textarea",{...u,name:s,cols:a,placeholder:c,required:m,rows:i}))},save:function({attributes:e}){const{cols:n,name:r,placeholder:l,required:a,rows:s}=e,c=o.useBlockProps.save();return(0,t.createElement)("textarea",{...c,name:r,cols:n,placeholder:l,required:a,rows:s})}})})();
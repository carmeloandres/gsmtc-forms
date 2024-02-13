(()=>{"use strict";const e=window.wp.blocks,t=window.React,n=window.wp.i18n,a=window.wp.blockEditor,l=window.wp.components;(0,e.registerBlockType)("gsmtc-forms/text",{edit:function({attributes:e,setAttributes:r}){const{name:o,defaultValue:i,required:s,validationPattern:u,validationMessage:m}=e,c=(0,a.useBlockProps)();return(0,t.createElement)(t.Fragment,null,(0,t.createElement)(a.InspectorControls,null,(0,t.createElement)(l.Panel,null,(0,t.createElement)(l.PanelBody,{title:(0,n.__)("Input text information ","gsmtc-forms"),initialOpen:!0},(0,t.createElement)(l.TextControl,{label:(0,n.__)("Input name","gsmtc-forms"),value:o,onChange:e=>r({name:e})}),(0,t.createElement)(l.TextControl,{label:(0,n.__)("Default value","gsmtc-forms"),value:i,onChange:e=>r({defaultValue:e})}),(0,t.createElement)(l.ToggleControl,{label:(0,n.__)("Required","gsmtc-forms"),checked:s,onChange:e=>r({required:e})})),(0,t.createElement)(l.PanelBody,{title:(0,n.__)("Input text validation ","gsmtc-forms"),initialOpen:!1},(0,t.createElement)(l.TextControl,{label:(0,n.__)("Validation regular pattern","gsmtc-forms"),value:u,onChange:e=>r({validationPattern:e})}),(0,t.createElement)(l.TextControl,{label:(0,n.__)("Validation message","gsmtc-forms"),value:m,onChange:e=>r({validationMessage:e})})))),(0,t.createElement)("input",{type:"text",...c,name:o,required:s,value:i,pattern:u,title:m}))},save:function({attributes:e}){const{name:n,defaultValue:l,required:r,validationPattern:o,validationMessage:i}=e,s=a.useBlockProps.save();return(0,t.createElement)("input",{type:"text",...s,value:l,name:n,required:r,pattern:o,title:i})}})})();
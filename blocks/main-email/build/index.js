(()=>{"use strict";const e=window.wp.blocks,i=window.React,n=(window.wp.i18n,window.wp.blockEditor);(0,e.registerBlockType)("gsmtc-forms/main-email",{edit:function(){const e=(0,n.useBlockProps)();return(0,i.createElement)("input",{type:"email",...e,name:"main-email",required:!0})},save:function(){const e=n.useBlockProps.save();return(0,i.createElement)("input",{type:"email",...e,name:"main-email",required:!0})}})})();
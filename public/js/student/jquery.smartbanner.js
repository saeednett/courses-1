/*!
 * jQuery Smart Banner
 * Copyright (c) 2012 Arnold Daniels <arnold@jasny.net>
 * Based on 'jQuery Smart Web App Banner' by Kurt Zenisek @ kzeni.com
 */
!function($){var SmartBanner=function(options){this.origHtmlMargin=parseFloat($('html').css('margin-top'))
this.options=$.extend({},$.smartbanner.defaults,options)
var standalone=navigator.standalone,UA=navigator.userAgent
if(this.options.force){this.type=this.options.force}else if(UA.match(/iPhone|iPod/i)!=null||(UA.match(/iPad/)&&this.options.iOSUniversalApp)){if(UA.match(/Safari/i)!=null&&(UA.match(/CriOS/i)!=null||window.Number(UA.substr(UA.indexOf('OS ')+3,3).replace('_','.'))<6))this.type='ios'}else if(UA.match(/\bSilk\/(.*\bMobile Safari\b)?/)||UA.match(/\bKF\w/)||UA.match('Kindle Fire')){this.type='kindle'}else if(UA.match(/Android/i)!=null){this.type='android'}else if(UA.match(/Windows NT 6.2/i)!=null&&UA.match(/Touch/i)!==null){this.type='windows'}
if(!this.type||standalone||this.getCookie('sb-closed')||this.getCookie('sb-installed')){return}
this.scale=this.options.scale=='auto'?$(window).width()/window.screen.width:this.options.scale
if(this.scale<1)this.scale=1
var meta=$(this.type=='android'?'meta[name="google-play-app"]':this.type=='ios'?'meta[name="apple-itunes-app"]':this.type=='kindle'?'meta[name="kindle-fire-app"]':'meta[name="msApplication-ID"]');if(meta.length==0)return
if(this.type=='windows'){this.pfn=$('meta[name="msApplication-PackageFamilyName"]').attr('content');this.appId=meta.attr('content')[1]}else{this.appId=/app-id=([^\s,]+)/.exec(meta.attr('content'))[1]}
this.title=this.options.title?this.options.title:meta.data('title')||$('title').text().replace(/\s*[|\-·].*$/,'')
this.author=this.options.author?this.options.author:meta.data('author')||($('meta[name="author"]').length?$('meta[name="author"]').attr('content'):window.location.hostname)
this.iconUrl=meta.data('icon-url');this.price=meta.data('price');this.create()
this.show()
this.listen()}
SmartBanner.prototype={constructor:SmartBanner,create:function(){var iconURL,link=(this.options.url?this.options.url:(this.type=='windows'?'ms-windows-store:PDP?PFN='+this.pfn:(this.type=='android'?'market://details?id=':(this.type=='kindle'?'amzn://apps/android?asin=':'https://itunes.apple.com/'+this.options.appStoreLanguage+'/app/id')))+this.appId),price=this.price||this.options.price,inStore=price?price+' - '+(this.type=='android'?this.options.inGooglePlay:this.type=='kindle'?this.options.inAmazonAppStore:this.type=='ios'?this.options.inAppStore:this.options.inWindowsStore):'',gloss=this.options.iconGloss===null?(this.type=='ios'):this.options.iconGloss
if(this.options.url)
link=this.options.url
else{if(this.type=='android'){link='market://details?id='+this.appId
if(this.options.GooglePlayParams)
link=link+'&referrer='+this.options.GooglePlayParams}
else
link='https://itunes.apple.com/'+this.options.appStoreLanguage+'/app/id'+this.appId}
var banner='<div id="smartbanner" class="'+this.type+'"><div class="sb-container"><a href="#" class="sb-close">&times;</a><span class="sb-icon"></span><div class="sb-info"><strong>'+this.title+'</strong><span>'+this.author+'</span><span>'+inStore+'</span></div><a href="'+link+'" class="sb-button"><span>'+this.options.button+'</span></a></div></div>';(this.options.layer)?$(this.options.appendToSelector).append(banner):$(this.options.appendToSelector).prepend(banner);if(this.options.icon){iconURL=this.options.icon}else if(this.iconUrl){iconURL=this.iconUrl;}else if($('link[rel="apple-touch-icon-precomposed"]').length>0){iconURL=$('link[rel="apple-touch-icon-precomposed"]').attr('href')
if(this.options.iconGloss===null)gloss=false}else if($('link[rel="apple-touch-icon"]').length>0){iconURL=$('link[rel="apple-touch-icon"]').attr('href')}else if($('meta[name="msApplication-TileImage"]').length>0){iconURL=$('meta[name="msApplication-TileImage"]').attr('content')}else if($('meta[name="msapplication-TileImage"]').length>0){iconURL=$('meta[name="msapplication-TileImage"]').attr('content')}
if(iconURL){$('#smartbanner .sb-icon').css('background-image','url('+iconURL+')')
if(gloss)$('#smartbanner .sb-icon').addClass('gloss')}else{$('#smartbanner').addClass('no-icon')}
this.bannerHeight=$('#smartbanner').outerHeight()+2
if(this.scale>1){$('#smartbanner').css('top',parseFloat($('#smartbanner').css('top'))*this.scale).css('height',parseFloat($('#smartbanner').css('height'))*this.scale).hide()
$('#smartbanner .sb-container').css('-webkit-transform','scale('+this.scale+')').css('-msie-transform','scale('+this.scale+')').css('-moz-transform','scale('+this.scale+')').css('width',$(window).width()/this.scale)}
$('#smartbanner').css('position',(this.options.layer)?'absolute':'static')},listen:function(){$('#smartbanner .sb-close').on('click',$.proxy(this.close,this))
$('#smartbanner .sb-button').on('click',$.proxy(this.install,this))},show:function(callback){var banner=$('#smartbanner');banner.stop();if(this.options.layer){banner.animate({top:0,display:'block'},this.options.speedIn).addClass('shown').show();$('html').animate({marginTop:this.origHtmlMargin+(this.bannerHeight*this.scale)},this.options.speedIn,'swing',callback);}else{if($.support.transition){banner.animate({top:0},this.options.speedIn).addClass('shown');var transitionCallback=function(){$('html').removeClass('sb-animation');if(callback){callback();}};$('html').addClass('sb-animation').one($.support.transition.end,transitionCallback).emulateTransitionEnd(this.options.speedIn).css('margin-top',this.origHtmlMargin+(this.bannerHeight*this.scale));}else{banner.slideDown(this.options.speedIn).addClass('shown');}}},hide:function(callback){var banner=$('#smartbanner');banner.stop();if(this.options.layer){banner.animate({top:-1*this.bannerHeight*this.scale,display:'block'},this.options.speedIn).removeClass('shown');$('html').animate({marginTop:this.origHtmlMargin},this.options.speedIn,'swing',callback);}else{if($.support.transition){banner.css('top',-1*this.bannerHeight*this.scale).removeClass('shown');var transitionCallback=function(){$('html').removeClass('sb-animation');if(callback){callback();}};$('html').addClass('sb-animation').one($.support.transition.end,transitionCallback).emulateTransitionEnd(this.options.speedOut).css('margin-top',this.origHtmlMargin);}else{banner.slideUp(this.options.speedOut).removeClass('shown');}}},close:function(e){e.preventDefault()
this.hide()
this.setCookie('sb-closed','true',this.options.daysHidden);},install:function(e){if(this.options.hideOnInstall){this.hide()}
this.setCookie('sb-installed','true',this.options.daysReminder)},setCookie:function(name,value,exdays){var exdate=new Date()
exdate.setDate(exdate.getDate()+exdays)
value=encodeURI(value)+((exdays==null)?'':'; expires='+exdate.toUTCString())
document.cookie=name+'='+value+'; path=/;'},getCookie:function(name){var i,x,y,ARRcookies=document.cookie.split(";")
for(i=0;i<ARRcookies.length;i++){x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="))
y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1)
x=x.replace(/^\s+|\s+$/g,"")
if(x==name){return decodeURI(y)}}
return null},switchType:function(){var that=this
this.hide(function(){that.type=that.type=='android'?'ios':'android'
var meta=$(that.type=='android'?'meta[name="google-play-app"]':'meta[name="apple-itunes-app"]').attr('content')
that.appId=/app-id=([^\s,]+)/.exec(meta)[1]
$('#smartbanner').detach()
that.create()
that.show()})}}
$.smartbanner=function(option){var $window=$(window),data=$window.data('smartbanner'),options=typeof option=='object'&&option
if(!data)$window.data('smartbanner',(data=new SmartBanner(options)))
if(typeof option=='string')data[option]()}
$.smartbanner.defaults={title:null,author:null,price:'FREE',appStoreLanguage:'us',inAppStore:'On the App Store',inGooglePlay:'In Google Play',inAmazonAppStore:'In the Amazon Appstore',inWindowsStore:'In the Windows Store',GooglePlayParams:null,icon:null,iconGloss:null,button:'VIEW',url:null,scale:'auto',speedIn:300,speedOut:400,daysHidden:15,daysReminder:90,force:null,hideOnInstall:true,layer:false,iOSUniversalApp:true,appendToSelector:'body'}
$.smartbanner.Constructor=SmartBanner;function transitionEnd(){var el=document.createElement('smartbanner')
var transEndEventNames={WebkitTransition:'webkitTransitionEnd',MozTransition:'transitionend',OTransition:'oTransitionEnd otransitionend',transition:'transitionend'}
for(var name in transEndEventNames){if(el.style[name]!==undefined){return{end:transEndEventNames[name]}}}
return false}
if($.support.transition!==undefined)
return
$.fn.emulateTransitionEnd=function(duration){var called=false,$el=this
$(this).one($.support.transition.end,function(){called=true})
var callback=function(){if(!called)$($el).trigger($.support.transition.end)}
setTimeout(callback,duration)
return this}
$(function(){$.support.transition=transitionEnd()})}(window.jQuery);
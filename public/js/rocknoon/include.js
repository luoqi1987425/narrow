if (typeof (rocknoon) == 'undefined') {
	
	var rocknoon = {};
	rocknoon.ajax = {};
	rocknoon.form = {};
	rocknoon.validate = {};
	rocknoon.version = 0.1;
	
	( function() {
		
		/* Codes Start Here */
		rocknoon.init = function() {
			/* Check if prototype is successful loaded */
			if ('undefined' == typeof (jQuery)) {
				throw new Error('You Need jquery Loaded first!');
			}
		};
		
		//namespace
		rocknoon.namespace = function(fullNS) {

			var nsArray = fullNS.split('.');
			var sEval = "";
			var sNS = "";
			for ( var i = 0; i < nsArray.length; i++) {
				if (i != 0)
					sNS += ".";
				sNS += nsArray[i];
				sEval += "if (typeof(" + sNS + ") == 'undefined') " + sNS
						+ " = new Object();";
			}
			if (sEval != "")
				eval(sEval);
		};
		
		
		//create function have params
		rocknoon.event = function(obj, strFunc) {
			var args = [];
			if (!obj)
				obj = window;
			for ( var i = 2; i < arguments.length; i++)
				args.push(arguments[i]);
			return function() {
				return obj[strFunc].apply(obj, args);
			}
		};
		
		//create function
		rocknoon.callback = function(obj, strFunc) {
			if (!obj)
				obj = window;
			return function() {
				return obj[strFunc].apply(obj, arguments);
			}
		};
		
		
		//ajax
		rocknoon.ajax.prase = function(response){
			
			var response_text = '';
			if('object'== typeof(response) && response.responseText)
			{
				response_text = response.responseText;
			}
			else
			{
				response_text = response;
			}
			
			var rst = null;
			try {
				eval('var rst=' + response_text);
			}
			catch(ex)
			{
				//do nothing
			}
			return rst;
			
		}
		
		
		//form 
		rocknoon.form.post = function( url , data ){
	        var form = document.createElement('form');
	        form.action = url;
	        form.method = 'POST';
	        $.each(data, function(key, val) {  
	        	var textfield = document.createElement('input');
				textfield.type = 'hidden';
				textfield.name  = key;
	            textfield.value = val;
	            form.appendChild(textfield);
	        }); 
	        document.body.appendChild(form);
	        form.submit();
		}
		
		
		//radio 
		rocknoon.form.radio = {};
		
		rocknoon.form.radio.val = function( ctlName , value ){
			
			if( value ){
				Radio.setVal( ctlName , value );
			}
			
		}
		
		rocknoon.form.radio.set_val = function( ctlName , value ){
			$('input[name='+ctlName+']').each(function(n){
			 	if( this.value == value ){
			 		this.checked = true;
			 	}else{
			 		this.checked = false;
			 	}
			 });
		}
		
		rocknoon.form.radio.get_val = function( ctlName ){
			
			var rtn;
			$('input[name='+ctlName+']').each(function(n){
				
				if( this.checked == true ){
					rtn = this.value;
				}
			 });
			
			return rtn;
		}
		
		//verification
		/*
		 * 数据验证正则
		 */
		var ValidateRegexEnum = {};
		ValidateRegexEnum = {
			Email : /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
			isChinesePhone : /^[0]{0,1}(13|15|18|14){1}(\d){1}(\d){8}$/,
			Mobile : /^((\(\d{2,3}\))|(\d{3}\-))?((13\d{9})|(15[389]\d{8}))$/,
			Url : /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"])*$/,
			Ip : /^(0|[1-9]\d?|[0-1]\d{2}|2[0-4]\d|25[0-5]).(0|[1-9]\d?|[0-1]\d{2}|2[0-4]\d|25[0-5]).(0|[1-9]\d?|[0-1]\d{2}|2[0-4]\d|25[0-5]).(0|[1-9]\d?|[0-1]\d{2}|2[0-4]\d|25[0-5])$/,
			Currency : /^\d+(\.\d+)?$/,
			Number : /^\d+$/,
			CountryCode : /^\+\d+$/,
			Float : /^[\+\-]?\d*?\.?\d*?$/,
			EurFloat : /^[\+\-]?\d*?\,?\d*?$/,
			Zip : /^[1-9]\d{5}$/,
			QQ : /^[1-9]\d{4,8}$/,
			English : /^[A-Za-z]+$/,
			Chinese :  /^[\u0391-\uFFE5]+$/,
			UserName : /^[a-z]\w{3,19}$/i,
			Integer : /^[-\+]?\d+$/,
			PasswordLength : 6
		};
		
		
		rocknoon.validate.is_email =  function( value ){
			var flag = ValidateRegexEnum.Email.test( value );
			return flag;
		}
		
		rocknoon.validate.is_number = function( value )
		{
			var flag = ValidateRegexEnum.Number.test( value );
			return flag;
		}
		
		rocknoon.validate.is_country_code = function( value )
		{
			var flag = ValidateRegexEnum.CountryCode.test( value );
			return flag;
		}
		
		rocknoon.validate.is_empty =  function( value ){
			value = trim( value );
			if( value == '' ){
				return true;
			}
			else{
				return false;
			}
		}
		
		function trim(  str, charlist  ){
			var whitespace, l = 0, i = 0;
			str += '';

			if (!charlist) {
				// default list
				whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
			} else {
				// preg_quote custom list
				charlist += '';
				whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g,
						'\$1');
			}

			l = str.length;
			for (i = 0; i < l; i++) {
				if (whitespace.indexOf(str.charAt(i)) === -1) {
					str = str.substring(i);
					break;
				}
			}

			l = str.length;
			for (i = l - 1; i >= 0; i--) {
				if (whitespace.indexOf(str.charAt(i)) === -1) {
					str = str.substring(0, i + 1);
					break;
				}
			}

			return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
		}
		
		
		
		//array
		Array.prototype.remove=function(dx)
		  {
		    if(isNaN(dx)||dx>this.length){return false;}
		    for(var i=0,n=0;i<this.length;i++)
		    {
		        if(this[i]!=this[dx])
		        {
		            this[n++]=this[i]
		        }
		    }
		    this.length-=1
		}

		
	})();

	rocknoon.init();
	
}
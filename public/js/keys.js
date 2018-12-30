//https://github.com/dmcblue/faded/blob/master/js/Lib/Keys.js
var Keys = 
	{
		__init : false,
		__pressed : {},
		init :
			function(){
				if(Keys.__init){return;}
				document.addEventListener(
					Keys.EVENT_TYPE_DOWN,
					function(e){
						var keynum;

						if(window.event) { // IE                    
							keynum = e.keyCode;
						} else if(e.which){ // Netscape/Firefox/Opera                   
							keynum = e.which;
						}
						
						Keys.__pressed[keynum] = true;
						Keys.propogate(Keys.EVENT_TYPE_DOWN, keynum, e);
					}
				);

				document.addEventListener(
					Keys.EVENT_TYPE_UP,
					function(e){
						var keynum;

						if(window.event) { // IE                    
							keynum = e.keyCode;
						} else if(e.which){ // Netscape/Firefox/Opera                   
							keynum = e.which;
						}
						
						Keys.__pressed[keynum] = false;
						Keys.propogate(Keys.EVENT_TYPE_UP, keynum, e);
					}
				);
				
				//NO keyPress...uses different key codes
				//http://unixpapa.com/js/key.html
				document.addEventListener(
					Keys.EVENT_TYPE_PRESS,
					function(e){
						var keynum;

						if(window.event) { // IE                    
							keynum = e.keyCode;
						} else if(e.which){ // Netscape/Firefox/Opera                   
							keynum = e.which;
						}
						
						Keys.propogate(Keys.EVENT_TYPE_PRESS, keynum, e);
					}
				);

				Keys.__init = true;
			},
		isPressed :
			function(keyCode){
				return Keys.__pressed[keyCode] ? Keys.__pressed[keyCode] : false;
			},
		propogate :
			function(type, keynum, event){
				for(var prop in Keys.SUBSCRIBERS[type]){
					if(Keys.SUBSCRIBERS[type].hasOwnProperty(prop)){
						Keys.SUBSCRIBERS[type][prop][Keys.INTERFACE_MAPPING[type]](keynum, event);
					}
				}
			},
		subscribe :
			function(type, item){
				var newUniqueId = 'key_subscriber' + Keys.SUBSCRIBER_ID++;
				Keys.SUBSCRIBERS[type][newUniqueId] = item;
				return newUniqueId;
			},
		unsubscribe :
			function(type, uniqueId){
				delete Keys.SUBSCRIBERS[type][uniqueId];
			},
		EVENT_TYPE_DOWN : 'keydown',
		EVENT_TYPE_PRESS : 'keypress',
		EVENT_TYPE_UP : 'keyup',
		INTERFACE_METHOD_DOWN : 'onKeyDown',
		INTERFACE_METHOD_PRESS : 'onKeyPress',
		INTERFACE_METHOD_UP : 'onKeyUp',
		INTERFACE_MAPPING : {
			'keydown' : 'onKeyDown',
			'keyup' : 'onKeyUp',
			'keypress' : 'onKeyPress'
		},
		SUBSCRIBER_ID : 0,
		SUBSCRIBERS : {
			'keydown' :  {},
			'keyup' : {},
			'keypress' : {}
		},
		KEY_SPACE         : 32,
		KEY_NUM_0         : 48,
		KEY_NUM_1         : 49,
		KEY_NUM_2         : 50,
		KEY_NUM_3         : 51,
		KEY_NUM_4         : 52,
		KEY_NUM_5         : 53,
		KEY_NUM_6         : 54,
		KEY_NUM_7         : 55,
		KEY_NUM_8         : 56,
		KEY_NUM_9         : 57,
		KEY_SEMI_COLON    : 59,
		KEY_EQUALS        : 61,
		KEY_A             : 65,
		KEY_B             : 66,
		KEY_C             : 67,
		KEY_D             : 68,
		KEY_E             : 69,
		KEY_F             : 70,
		KEY_G             : 71,
		KEY_H             : 72,
		KEY_I             : 73,
		KEY_J             : 74,
		KEY_K             : 75,
		KEY_L             : 76,
		KEY_M             : 77,
		KEY_N             : 78,
		KEY_O             : 79,
		KEY_P             : 80,
		KEY_Q             : 81,
		KEY_R             : 82,
		KEY_S             : 83,
		KEY_T             : 84,
		KEY_U             : 85,
		KEY_V             : 86,
		KEY_W             : 87,
		KEY_X             : 88,
		KEY_Y             : 89,
		KEY_Z             : 90,
		KEY_NUM_PAD_0     : 96,
		KEY_NUM_PAD_1     : 97,
		KEY_NUM_PAD_2     : 98,
		KEY_NUM_PAD_3     : 99,
		KEY_NUM_PAD_4     : 100,
		KEY_NUM_PAD_5     : 101,
		KEY_NUM_PAD_6     : 102,
		KEY_NUM_PAD_7     : 103,
		KEY_NUM_PAD_8     : 104,
		KEY_NUM_PAD_9     : 105,
		KEY_MULTIPLY      : 106,
		KEY_ADD           : 107,
		KEY_SEPARATOR     : 108,
		KEY_SUBTRACT      : 109,
		KEY_DECIMAL       : 110,
		KEY_DIVIDE        : 111,
		KEY_COMMA         : 188,
		KEY_PERIOD        : 190,
		KEY_SLASH         : 191,
		KEY_BACK_QUOTE    : 192,
		KEY_OPEN_BRACKET  : 219,
		KEY_BACK_SLASH    : 220,
		KEY_CLOSE_BRACKET : 221,
		KEY_QUOTE         : 222,
		KEY_META          : 224,
		KEY_CANCEL        : 3,
		KEY_HELP          : 6,
		KEY_BACK_SPACE    : 8,
		KEY_TAB           : 9,
		KEY_CLEAR         : 12,
		KEY_ENTER         : 13,
		KEY_SHIFT         : 16,
		KEY_CONTROL       : 17,
		KEY_ALT           : 18,
		KEY_PAUSE         : 19,
		KEY_CAPS_LOCK     : 20,
		KEY_ESCAPE        : 27,
		KEY_PAGE_UP       : 33,
		KEY_PAGE_DOWN     : 34,
		KEY_END           : 35,
		KEY_HOME          : 36,
		KEY_LEFT          : 37,
		KEY_UP            : 38,
		KEY_RIGHT         : 39,
		KEY_DOWN          : 40,
		KEY_PRINT_SCREEN  : 44,
		KEY_INSERT        : 45,
		KEY_DELETE        : 46,
		KEY_CONTEXT_MENU  : 93,
		KEY_F1            : 112,
		KEY_F2            : 113,
		KEY_F3            : 114,
		KEY_F4            : 115,
		KEY_F5            : 116,
		KEY_F6            : 117,
		KEY_F7            : 118,
		KEY_F8            : 119,
		KEY_F9            : 120,
		KEY_F10           : 121,
		KEY_F11           : 122,
		KEY_F12           : 123,
		KEY_F13           : 124,
		KEY_F14           : 125,
		KEY_F15           : 126,
		KEY_F16           : 127,
		KEY_F17           : 128,
		KEY_F18           : 129,
		KEY_F19           : 130,
		KEY_F20           : 131,
		KEY_F21           : 132,
		KEY_F22           : 133,
		KEY_F23           : 134,
		KEY_F24           : 135,
		KEY_NUM_LOCK      : 144,
		KEY_SCROLL_LOCK   : 145
	};
Keys.init();
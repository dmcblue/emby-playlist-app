var EmbyPlaylistApp = EmbyPlaylistApp || {
    lastItemSelected: null,
    itemSelectedClass: 'checked', 

    Api: {
        _endPoint: null,

        add: function(playlistName, file, onResponse) {
            var url = EmbyPlaylistApp.Api.endPoint() + 'add';
            EmbyPlaylistApp.Api.post(
                url, 
                {
                    playlistName: playlistName,
                    file: file
                }, 
                onResponse
            );
        },

        endPoint: function () {
            if(EmbyPlaylistApp.Api._endPoint == null) {
                var baseInput = document.querySelector('#baseUrl');
                EmbyPlaylistApp.Api._endPoint = baseInput.value + '/api/';
            }
            
            return EmbyPlaylistApp.Api._endPoint;
        },

        post: function(url, data, onReponse) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            if(onReponse) {
                xhr.onreadystatechange = (function(onResponse) {
                    return function(){
                        if(this.readyState == 4) {
                            var response = JSON.parse(this.response);
                            onResponse(response);
                        }
                    }
                })(onReponse);
            }

            xhr.send(JSON.stringify(data));
        },

        remove: function(playlistName, file, onResponse) {
            var url = EmbyPlaylistApp.Api.endPoint() + 'remove';
            EmbyPlaylistApp.Api.post(
                url, 
                {
                    playlistName: playlistName,
                    file: file
                }, 
                onResponse
            );
        },
    },

    Class: {
        add: function(element, className) {
            var classes = element.className.split(' ');
            classes.push(className);
            element.className = classes.join(' ');
        },

        has: function(element, className) {
            var classes = element.className.split(' ');
            return classes.indexOf(className) > -1;
        },

        remove: function(element, className) {
            var classes = element.className.split(' ');
            var index = classes.indexOf(className);
            while(index !== -1) {
                classes.splice(classes.indexOf(className), 1);
                index = classes.indexOf(className);
            }
            
            element.className = classes.join(' ');
        },

        toggle: function(element, className) {
            if(EmbyPlaylistApp.Class.has(element, className)) {
                EmbyPlaylistApp.Class.remove(element, className);
            } else {
                EmbyPlaylistApp.Class.add(element, className);
            }
        }
    },

    Element: {
        remove: function(element){
            element.parentNode.removeChild(element);
        }
    },

    Menu: {
        call: function(event, menuId) {
            event.preventDefault();
            event.stopPropagation();
            
            var menu = document.getElementById(menuId);
            menu.style.top = event.pageY + 'px';
            menu.style.left = event.pageX + 'px';
        },

        hideAll: function () {
            var items = document.querySelectorAll('.right-click-menu');
            for(item of items) {
                item.style.top = '-100%';
                item.style.left = '-100%';
            }
        }
    },

    Message: {
        boxId: 'message-box',
        showClass: 'show',
        time: 100, //ms,
        factor: 0.05,

        fade: function() {
            var box = document.getElementById(EmbyPlaylistApp.Message.boxId);

            var opacity = parseFloat(box.style.opacity) - EmbyPlaylistApp.Message.factor;
            
            if(opacity <= 0) {
                box.style.opacity = 0;
                EmbyPlaylistApp.Class.remove(box, EmbyPlaylistApp.Message.showClass);
            } else {
                box.style.opacity = opacity;
                setTimeout(EmbyPlaylistApp.Message.fade, EmbyPlaylistApp.Message.time);
            }
        },

        show: function(message) {
            var box = document.getElementById(EmbyPlaylistApp.Message.boxId);

            box.textContent = message;
            EmbyPlaylistApp.Class.add(box, EmbyPlaylistApp.Message.showClass);
            var opacity = parseFloat(box.style.opacity || 0);
            
            box.style.opacity = 1;
            if(opacity <= 0) {
                setTimeout(EmbyPlaylistApp.Message.fade, EmbyPlaylistApp.Message.time);
            }
        }
    },

    Playlist: {
        select: function(event) {
            event.preventDefault();
            event.stopPropagation();
            EmbyPlaylistApp.Menu.hideAll();
            
            if(Keys.isPressed(Keys.KEY_SHIFT) && EmbyPlaylistApp.lastItemSelected !== null) {
                EmbyPlaylistApp.Playlist.deselectAll();
                var direction = this.dataset.count > EmbyPlaylistApp.lastItemSelected;
                var start = direction ? EmbyPlaylistApp.lastItemSelected : this.dataset.count;
                var end = !direction ? EmbyPlaylistApp.lastItemSelected : this.dataset.count;
                
                for(var i = start; i <= end; i++) {
                    var item = this.parentNode.querySelector('li.item' + i);
                    
                    if(item) {
                        EmbyPlaylistApp.Class.add(item, EmbyPlaylistApp.itemSelectedClass);
                    }
                }

            } else if(Keys.isPressed(Keys.KEY_CONTROL)) {
                EmbyPlaylistApp.Class.add(this, EmbyPlaylistApp.itemSelectedClass);
                EmbyPlaylistApp.lastItemSelected = this.dataset.count;
            } else {
                EmbyPlaylistApp.Playlist.deselectAll();
                EmbyPlaylistApp.Class.toggle(this, EmbyPlaylistApp.itemSelectedClass);
                EmbyPlaylistApp.lastItemSelected = this.dataset.count;
            }
        },

        deselectAll: function() {
            var items = document.querySelectorAll('ul.filelist.selectable li');

            for(item of items) {
                EmbyPlaylistApp.Class.remove(item, EmbyPlaylistApp.itemSelectedClass);
            }
        }
    }
};

window.addEventListener('load', function() {
    document.body.addEventListener('click', EmbyPlaylistApp.Menu.hideAll);
    var menus = document.querySelectorAll('.right-click-menu');
    for(menu of menus) {
        menu.addEventListener('click', function(event){event.stopPropagation();});
    }

    var filelist = document.querySelector('ul.filelist.selectable');
    if(filelist) {
        document.body.addEventListener('click', function() {
            EmbyPlaylistApp.Playlist.deselectAll();
            EmbyPlaylistApp.lastItemSelected = null;
        });
    }

    var filelists = document.querySelectorAll('ul.filelist.selectable');
    for(filelist of filelists) {
        var listitems = filelist.querySelectorAll('li');
        for(listitem of listitems) {
            listitem.addEventListener('click', EmbyPlaylistApp.Playlist.select);
        }
    }


    var playlistItems = document.querySelectorAll('.playlist-item');
    for(item of playlistItems) {
        item.addEventListener('contextmenu', function(event) {
            var checkedItems = this.parentNode.querySelectorAll('.' + EmbyPlaylistApp.itemSelectedClass);
            if(checkedItems.length === 0) {
                EmbyPlaylistApp.Class.add(this, EmbyPlaylistApp.itemSelectedClass);
            }

            EmbyPlaylistApp.Menu.call(event, 'playlist-item-menu');
        });
    }

    var removeItemsButton = document.getElementById('playlist-item-menu-remove');
    if(removeItemsButton) {
        removeItemsButton.addEventListener('click', function(event){
            var playlistItems = document.querySelectorAll('.playlist-item.' + EmbyPlaylistApp.itemSelectedClass);
            for(item of playlistItems) {
                EmbyPlaylistApp.Element.remove(item);
            }
        });
    }

    var filelistItems = document.querySelectorAll('.files.filelist.selectable li');
    for(item of filelistItems) {
        item.addEventListener('contextmenu', function(event) {
            var checkedItems = this.parentNode.querySelectorAll('.' + EmbyPlaylistApp.itemSelectedClass);
            if(checkedItems.length > 1) {
                document.getElementById('filelist-item-menu-multi-num').textContent = checkedItems.length;

                EmbyPlaylistApp.Menu.call(event, 'filelist-item-menu-multi');
            } else {
                if(checkedItems.length === 0) {
                    EmbyPlaylistApp.Class.add(this, EmbyPlaylistApp.itemSelectedClass);
                }

                EmbyPlaylistApp.Menu.call(event, 'filelist-item-menu-single');
            }
        });
    }

    var manageInputs = document.querySelectorAll('.filelist-item-menu-manage-input');
    for(manageInput of manageInputs) {
        manageInput.addEventListener('change', function(event){
            var checkedItems = document.querySelectorAll('.' + EmbyPlaylistApp.itemSelectedClass);

            var method = this.checked ? 'add' : 'remove';

            for(checkedItem of checkedItems) {
                EmbyPlaylistApp.Api[method](this.value, checkedItem.dataset.file);
            }
            EmbyPlaylistApp.Message.show(checkedItems.length + ' items ' + (this.checked ? 'added' : 'removed'));
        });
    }
    
    var addItems = document.querySelectorAll('.filelist-item-menu-add');
    for(addItem of addItems) {
        addItem.addEventListener('click', function(event){
            var checkedItems = document.querySelectorAll('.' + EmbyPlaylistApp.itemSelectedClass);

            for(checkedItem of checkedItems) {
                console.log(this, this.dataset);
                EmbyPlaylistApp.Api.add(this.dataset.listname, checkedItem.dataset.file);
            }

            EmbyPlaylistApp.Message.show(checkedItems.length + ' items added');
            EmbyPlaylistApp.Menu.hideAll();
        });
    }
})

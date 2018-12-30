var EmbyPlaylistApp = EmbyPlaylistApp || {
    lastItemSelected: null,
    itemSelectedClass: 'checked', 

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

    Playlist: {
        deselectAll: function() {
            var playlistItems = document.querySelectorAll('.playlist-item');

            for(item of playlistItems) {
                EmbyPlaylistApp.Class.remove(item, EmbyPlaylistApp.itemSelectedClass);
            }
        }
    }
};

function resetToolTips() {
    var items = document.querySelectorAll('.right-click-menu');
    for(item of items) {
        item.style.top = '-100%';
        item.style.left = '-100%';
    }
}

window.addEventListener('load', function() {
    document.body.addEventListener('click', function() {
        resetToolTips();
    });

    var playlistEditor = document.querySelector('.playlist-editor');
    if(playlistEditor) {
        document.body.addEventListener('click', function() {
            EmbyPlaylistApp.Playlist.deselectAll();
            EmbyPlaylistApp.lastItemSelected = null;
        });
    }



    var playlistItems = document.querySelectorAll('.playlist-item');

    for(item of playlistItems) {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            resetToolTips();
            
            if(Keys.isPressed(Keys.KEY_SHIFT) && EmbyPlaylistApp.lastItemSelected !== null) {
                EmbyPlaylistApp.Playlist.deselectAll();
                var direction = this.dataset.count > EmbyPlaylistApp.lastItemSelected;
                var start = direction ? EmbyPlaylistApp.lastItemSelected : this.dataset.count;
                var end = !direction ? EmbyPlaylistApp.lastItemSelected : this.dataset.count;
                
                for(var i = start; i <= end; i++) {
                    var item = document.querySelector('.playlist-item.item' + i);
                    
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
            
        });

        item.addEventListener('contextmenu', function(event) {
            event.preventDefault();
            event.stopPropagation();
            console.log('right click!', event);
            var menu = document.getElementById('playlist-item-menu');
            console.log(menu);
            menu.style.top = event.pageY + 'px';
            menu.style.left = event.pageX + 'px';
        });
    }

    var removeItemsButton = document.getElementById('playlist-item-menu-remove');
    removeItemsButton.addEventListener('click', function(event){
        console.log(event);
        var playlistItems = document.querySelectorAll('.playlist-item.' + EmbyPlaylistApp.itemSelectedClass);
        for(item of playlistItems) {
            EmbyPlaylistApp.Element.remove(item);
        }

        
    })
})

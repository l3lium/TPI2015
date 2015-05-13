/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    var player = new vlocPlayer();

});


function vlocPlayer() {
    this.dom = $("#vloc-video");
    this.player = this.dom.get(0);
    this.controls = $("#vloc-controls");
    this.textTracks = this.dom.prop("textTracks");

    this.getControls();
    this.initialize();
    this.setEvent();
}

vlocPlayer.prototype.getControls = function () {
    this.btnPlay = this.controls.children("#vloc-btn-play");
    this.btnPause = this.controls.children("#vloc-btn-pause");
    this.btnStop = this.controls.children("#vloc-btn-stop");
    this.progressBar = this.controls.children("#vloc-progress-bar");
    this.btnsChapters = this.controls.find("#vloc-chapter-group .chapter-item");
    this.btnMute = this.controls.children("#vloc-btn-mute");
    this.btnUnMute = this.controls.children("#vloc-btn-unmute");
    this.btnFullscreen = this.controls.children("#vloc-btn-fullscreen");
    this.btnNormalScreen = this.controls.children("#vloc-btn-normalscreen");
    this.lbCurrentTime = this.controls.children("#vloc-current-time");
    this.lbDuration = this.controls.children("#vloc-duration");
}

vlocPlayer.prototype.initialize = function () {
    this.player.duration = 0;

    this.btnPause.hide();
    this.btnUnMute.hide();
    this.btnNormalScreen.hide();

    this.hideSubs();
}

vlocPlayer.prototype.setEvent = function () {
    var self = this;
    this.btnPlay.click(function () {
        self.play();
    });
    this.btnPause.click(function () {
        self.pause();
    });
    this.btnStop.click(function () {
        self.stop();
    });
    this.btnMute.click(function () {
        self.mute();
    });
    this.btnUnMute.click(function () {
        self.unmute();
    });
    this.btnFullscreen.click(function () {
        self.fullscreen();
    });
    $(this.player).on("timeupdate", function () {
        self.update();
    });
    
    this.btnsChapters.click(function () {
        var id = $(this).attr("data-idsub");
        var check = $(this).find("span");
        if (check.attr("class")) {
            self.changeSub(-1);
            check.removeClass();
        } else {
            self.btnsChapters.each(function(){
                $(this).find("span").removeClass();
            });
            self.changeSub(id);
            check.attr("class", "glyphicon glyphicon-ok");
        }
    });

    this.progressBar.click(function (event) {
        var pos = event.offsetX / event.target.clientWidth;
        self.setTime(pos * self.player.duration);
    });
}


vlocPlayer.prototype.setTime = function (time) {
    this.player.currentTime = time;
}

vlocPlayer.prototype.play = function () {
    this.btnPause.show();
    this.btnPlay.hide();
    this.player.play();
}

vlocPlayer.prototype.pause = function () {
    this.btnPause.hide();
    this.btnPlay.show();
    this.player.pause();
}

vlocPlayer.prototype.stop = function () {
    this.pause();
    this.setTime(0);
}

vlocPlayer.prototype.mute = function () {
    this.btnMute.hide();
    this.btnUnMute.show();
    this.player.muted = true;
}

vlocPlayer.prototype.unmute = function () {
    this.btnMute.show();
    this.btnUnMute.hide();
    this.player.muted = false;
}

vlocPlayer.prototype.debug = function (element) {
    console.debug(element);
}

vlocPlayer.prototype.fullscreen = function () {
    if (this.player.requestFullscreen) {
        this.player.requestFullscreen();
    }
    else if (this.player.mozRequestFullScreen) {
        this.player.mozRequestFullScreen();
    }
    else if (this.player.webkitRequestFullScreen) {
        this.player.webkitRequestFullScreen();
    }
}

vlocPlayer.prototype.changeSub = function (id) {
    var track = this.player.textTracks[id];
    if (id == -1) {
        this.actualTrack.mode = "hidden";
        this.actualTrack = null;
    } else {
        track.mode = "showing";
        if (this.actualTrack != null) {
            this.actualTrack.mode = "hidden";
        }
        this.actualTrack = track;
    }
}

vlocPlayer.prototype.hideSubs = function () {
    $(this.textTracks).each(function () {
        this.mode = "hidden";
    });
    this.actualTrack = null;
}

vlocPlayer.prototype.update = function () {
    this.lbDuration.html(formatTime(this.player.duration));
    this.lbCurrentTime.html(formatTime(this.player.currentTime));
    var percent = Math.floor(100 * this.player.currentTime / this.player.duration);
    this.progressBar.val(percent);
}

function formatTime(seconds) {
    if (isNaN(seconds))
        seconds = 0;
    minutes = Math.floor(seconds / 60);
    minutes = (minutes >= 10) ? minutes : "0" + minutes;
    seconds = Math.floor(seconds % 60);
    seconds = (seconds >= 10) ? seconds : "0" + seconds;
    return minutes + ":" + seconds;
}
(function ($) {
    var actions = {
        start: function () {
            var $preloader = $("<div id='jpreloader' class='preloader-overlay'><div class='loader' style='position:absolute;left:50%;top:50%;margin-left:-24px;margin-top:-24px;'><svg width='64px'  height='64px'  xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' preserveAspectRatio='xMidYMid' class='lds-dual-ring' style='background: none;'><circle cx='50' cy='50' ng-attr-r='{{config.radius}}' ng-attr-stroke-width='{{config.width}}' ng-attr-stroke='{{config.stroke}}' ng-attr-stroke-dasharray='{{config.dasharray}}' fill='none' stroke-linecap='round' r='40' stroke-width='6' stroke='#337ab7' stroke-dasharray='62.83185307179586 62.83185307179586' transform='rotate(300 50 50)'><animateTransform attributeName='transform' type='rotate' calcMode='linear' values='0 50 50;360 50 50' keyTimes='0;1' dur='1s' begin='0s' repeatCount='indefinite'></animateTransform></circle></svg></div></div>");
            $preloader.css({
                'background-color': '#4c4c4c',
                'width': '100%',
                'height': '100%',
                'left': '0',
                'top': '0',
                'opacity': '0.3',
                'z-index': '100',
                'position': 'absolute'
            });
            this.append($preloader);
        },

        stop: function () {
            this.find('.preloader-overlay').remove();
        }
    };

    $.fn.preloader = function (action) {
        actions[action].apply(this);
        return this;
    };
}(jQuery));
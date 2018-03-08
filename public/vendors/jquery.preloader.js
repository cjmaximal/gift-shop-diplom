(function ($) {
    var actions = {
        start: function () {
            var $preloader = $("<div id='jpreloader' class='preloader-overlay'><div class='loader' style='position:absolute;left:50%;top:50%;margin-left:-24px;margin-top:-24px;'><svg width='64px'  height='64px'  xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' preserveAspectRatio='xMidYMid' class='lds-infinity' style='background: none;'><path fill='none' ng-attr-stroke='{{config.stroke}}' ng-attr-stroke-width='{{config.width}}' ng-attr-stroke-dasharray='{{config.dasharray}}' d='M24.3,30C11.4,30,5,43.3,5,50s6.4,20,19.3,20c19.3,0,32.1-40,51.4-40 C88.6,30,95,43.3,95,50s-6.4,20-19.3,20C56.4,70,43.6,30,24.3,30z' stroke='#0051a2' stroke-width='8' stroke-dasharray='195.00758544921877 61.581342773437484'><animate attributeName='stroke-dashoffset' calcMode='linear' values='0;256.58892822265625' keyTimes='0;1' dur='1' begin='0s' repeatCount='indefinite'></animate></path></svg></div></div>");
            $preloader.css({
                'background-color': 'rgba(100,100,100,0.3)',
                'width': '100%',
                'height': '100%',
                'left': '0',
                'top': '0',
                'opacity': '1',
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
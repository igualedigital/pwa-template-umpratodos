pwaFw.views = {};
pwaFw.views.home = function(){

    this.viewInit = function(){

        console.log('%cwebapp->[home]:', 'background: #F8FF09;color: #292922','success');

        // [+] configuração do webapp
        let clickCount = 0;
        const clickLimit = 5;
        const clickInterval = 500; // 1/2 segundo para resetar o contador
        let lastClickTime = 0;

    $('.home-view').on('click touchstart', function() {
    
        const currentTime = new Date().getTime();
        if (currentTime - lastClickTime > clickInterval) {
            clickCount = 0; // Reset if clicks are not within the interval
        }

        clickCount++;
        lastClickTime = currentTime;

        console.log('click:',clickCount);
        if (clickCount >= clickLimit) {
            pwaFw.viewLoader('configuracao');
            clickCount = 0; // Reset the counter after loading the view
        }
    });
    // [-] configuração do webapp

        return;

    }

};

    // boot view
    var viewPage = new pwaFw.views.home();
    viewPage.viewInit();
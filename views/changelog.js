pwaFw.views = {};
pwaFw.views.changelog = function(){

    this.viewInit = function() {
        

        console.log('%cwebapp->[ChangeLog: Detalhes da Versão]:', 'background: #F8FF09;color: #292922', 'success');

    // retorna as configurações
    $('#btn_voltar').on('click', function() {
        //pwaFw.viewLoader('configuracao');
        pwaFw.viewLoader('configuracao');
    });


    }; // eof; init
    


};

    // boot view
    var viewPage = new pwaFw.views.changelog();
    viewPage.viewInit();
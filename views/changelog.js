qrCodeFw.views = {};
qrCodeFw.views.changelog = function(){

    this.viewInit = function() {
        

        console.log('%cwebapp->[ChangeLog: Detalhes da Versão]:', 'background: #F8FF09;color: #292922', 'success');

    // retorna as configurações
    $('#btn_voltar').on('click', function() {
        //qrCodeFw.viewLoader('configuracao');
        qrCodeFw.viewLoader('configuracao');
    });


    }; // eof; init
    


};

    // boot view
    var viewPage = new qrCodeFw.views.changelog();
    viewPage.viewInit();
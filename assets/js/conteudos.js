qrCodeFw.conteudo = qrCodeFw.conteudo || {};


/**
 * Adicione todos os conteúdos necessários para o webapp aqui.
 * 
 * Caso um item não tenha imagem/banner, defina o valor como null.
 * Exclua ou comente os exemplos conforme necessário para a construção de novos aplicativos.
 * 
 * Documentação:
 * A documentação da classe de conteúdos está localizada no arquivo class.MediaTracks.js.
 * 
 * Importante:
 * No main.js, há uma rotina que verifica se um recurso tem algum conteúdo definido.
 * Se nenhum conteúdo for encontrado para um recurso específico, o botão correspondente 
 * ao recurso de acessibilidade é automaticamente removido.
 * 
 * Dessa forma, para não exibir um recurso de acessibilidade, basta não definir nenhum conteúdo para ele.
 */


qrCodeFw.conteudo = new ColecaoFaixas();

// AUDIO

// Adicione as faixas de áudio com imagens de banners e descrição (Audiodescrição)
// Lembre-se de adicionar os caminhos dos arquivos no serviceWorker (sw.js)

    qrCodeFw.conteudo.adicionarFaixa('Faixa AD Exemplo', 'sample.jpg', 'Descrição da imagem', 'sample.mp3', 'audio');
    qrCodeFw.conteudo.adicionarFaixa('Faixa AD Exemplo 1 sem banner', null, null, 'sample-1.mp3', 'audio');
    qrCodeFw.conteudo.adicionarFaixa('Faixa AD Exemplo 2', 'sample-2.jpg', 'Descrição da imagem 2', 'sample-2.mp3', 'audio');
    qrCodeFw.conteudo.adicionarFaixa('Faixa AD Exemplo 3', 'sample-3.jpg', 'Descrição da imagem 3', 'sample-3.mp3', 'audio');
    
// VÍDEO

// Adicione os vídeos com imagens de banners e descrição (Libras)
// Lembre-se de adicionar os caminhos dos arquivos no serviceWorker (sw.js)

    qrCodeFw.conteudo.adicionarFaixa('Faixa Libras Exemplo',  null, 'Descrição da imagem', 'sample-portrait.mp4', 'video');
    //qrCodeFw.conteudo.adicionarFaixa('Faixa Libras Exemplo 1', null, 'Descrição da imagem 1', 'sample-1.mp4', 'video');
    //qrCodeFw.conteudo.adicionarFaixa('Faixa Libras Exemplo 2',  null, 'Descrição da imagem 2', 'sample-2.mp4', 'video');
    //qrCodeFw.conteudo.adicionarFaixa('Faixa Libras Exemplo 3',  null, 'Descrição da imagem 3', 'sample-3.mp4', 'video');

// TEXTO

// Adicione os textos com imagens de banners e descrição (Libras)
// Lembre-se de adicionar os caminhos dos arquivos no serviceWorker (sw.js)

   qrCodeFw.conteudo.adicionarFaixa('Texto exemplo', 'sample.jpg', 'Descrição da imagem', 'sample.html', 'text');
   //qrCodeFw.conteudo.adicionarFaixa('Texto exemplo 1 sem banner', null, 'Descrição da imagem 1', 'sample-1.html', 'text');
   //qrCodeFw.conteudo.adicionarFaixa('Texto exemplo 2', 'sample-2.jpg', 'Descrição da imagem 2', 'sample-2.html', 'text');
   //qrCodeFw.conteudo.adicionarFaixa('Texto exemplo 3', 'sample-3.jpg', 'Descrição da imagem 3', 'sample-3.html', 'text');

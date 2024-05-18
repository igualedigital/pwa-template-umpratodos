var qrCodeFw = {};
// [+] MediaClass
 /**
 * Classe que representa uma faixa de mídia, contendo informações sobre título, imagem, descrição da imagem, arquivo e tipo.
 * 
 * @param {string} titulo - O título da faixa.
 * @param {string} imagem - A URL da imagem da faixa.
 * @param {string} descricao_da_imagem - A descrição da imagem.
 * @param {string} arquivo - A URL do arquivo de mídia.
 * @param {string} tipo - O tipo de mídia (áudio ou vídeo).
 * 
 * Exemplo de uso
 * 
 * const minhaColecao = new ColecaoFaixas();
 * minhaColecao.adicionarFaixa('Faixa Exemplo', 'sample.jpg', 'Descrição da imagem', 'sample.mp3', 'audio');
 * minhaColecao.adicionarFaixa('Faixa Exemplo 1', null, 'Descrição da imagem 1', 'sample-1.mp4', 'video');
 * minhaColecao.adicionarFaixa('Faixa Exemplo 2', 'sample-2.jpg', 'Descrição da imagem 2', 'sample-2.mp3', 'audio');
 * minhaColecao.adicionarFaixa('Texto Exemplo', 'sample-3.jpg', 'Descrição da imagem 3', 'sample-3.html', 'text');
 * console.log('Existem (audio):', minhaColecao.listarFaixas('audio').length);
 * console.log('Existem (video):', minhaColecao.listarFaixas('video').length);
 * console.log('Existem (text):', minhaColecao.listarFaixas('text').length);
 * 
 */

 class MediaTracks {
    constructor(titulo, imagem, descricao_da_imagem, arquivo, tipo) {
      this.titulo = titulo; // Título da faixa
      this.imagem = imagem; // URL da imagem da faixa
      this.descricao_da_imagem = descricao_da_imagem; // Descrição da imagem
      this.arquivo = arquivo; // URL do arquivo de mídia
      this.tipo = tipo; // Tipo de mídia (áudio, vídeo ou texto)
    }
  }
  
  // Definição do objeto que armazena várias faixas
  class ColecaoFaixas {
    constructor() {
      this.faixas = []; // Array para armazenar as faixas de mídia
    }
  
    // Método para adicionar uma nova faixa à coleção
    adicionarFaixa(titulo, imagem, descricao_da_imagem, arquivo, tipo) {
      let caminhoImagem = null;
      let descricaoImagem = null;
  
      if (imagem) {
        caminhoImagem = 'storage/media/image/' + imagem;
        descricaoImagem = descricao_da_imagem;
      }
  
      let caminhoArquivo;
      if (tipo === 'audio') {
        caminhoArquivo = 'storage/media/audio/' + arquivo;
      } else if (tipo === 'video') {
        caminhoArquivo = 'storage/media/video/' + arquivo;
      } else if (tipo === 'text') {
        caminhoArquivo = 'storage/media/text/' + arquivo;
      } else {
        throw new Error('Tipo de mídia inválido');
      }
  
      const novaFaixa = new MediaTracks(titulo, caminhoImagem, descricaoImagem, caminhoArquivo, tipo);
      this.faixas.push(novaFaixa);
    }
  
    // Método para remover uma faixa da coleção pelo título
    removerFaixa(titulo) {
      this.faixas = this.faixas.filter(faixa => faixa.titulo !== titulo);
    }
  
    // Método para listar todas as faixas ou filtradas por áudio, vídeo ou texto
    listarFaixas(tipo = null) {
      if (tipo) {
        return this.faixas.filter(faixa => faixa.tipo === tipo);
      }
      return this.faixas;
    }
  
    // Método para contar o número total de faixas
    contarFaixas(tipo = null) {
      if (tipo) {
          return this.faixas.filter(faixa => faixa.tipo === tipo).length;
      }
      return this.faixas.length;
  }
  }; // end of class
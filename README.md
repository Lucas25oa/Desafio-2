<h1 style="text-transform: uppercase;">Desafio 2</h1>



<h2 style="text-transform: uppercase;">Descrição</h2>

O modulo disponivel para download, tem a finalidade de adicionar uma cor de todos os botões disponiveis na loja.
Atravês do command line (cli) do magento, utilizando um comando basico, como por exemplo: ".bin/magento 00000 1". Após fazer isso, todos os buttons na tag <buttons>, serão mudados para a cor hexadecimal escolhida.

<h2 style="text-transform: uppercase;">Como foi desenvolvido.</h2>

Basicamente foi desenvolvido da seguinte forma.

1° Primeiro foi adicionado um arquivo xml, para declarar o comando cli do magento e declarar um interceptor para obter o storeView que está sendo acessado.

2° Após isso foi adicionado outro arquivo xml, para adicionar um css de nome "change-buttons.css", para que ali fiquem as classes com as cores dos botões.

2° Após isso , foi escrito dentro do arquivo cli, uma logica responsavel por, encontrar o arquivo css "change-buttons.css", e adicionar uma nova classe utilizando a cor hexadecimal e o id válidos. A partir do seguinte padrão: 
    - Utilizando o comando ".bin/magento 000000 1", adicionamos uma classe seguindo o padrão ".store-view-1 button { background-color: #000000 !important; }".

3° Depois, foi implementado dentro do interceptor a capacidade de obter o id da atual store view, e adicionar a tag body, no momento em que a página é acessada. Para poder ter uma classe que diferencia cada store view que está ativa. Por exemplo: se for a store view 1 , a tag do body irá mostrar store-view-1, se for a segunda store-view-2, e assim sucessivamente. Aplicando então as cores de forma automatica , a partir do id ativo no momento.



<h2 style="text-transform: uppercase;">Passo a Passo da instalação.</h2>

1° Faça download do modulo através dessa pasta do github.

2° Adicione dentro de "app/code/".

3° php bin/magento module:enable "Hibrido_ChangeCollorAllButtons"

4° php bin/magento setup:di:compile

5° php bin/magento cache:flush



Passo a Passo utilização.

Para adicionar ou alterar uma cor a store view.

1° No terminal .bin/magento 00000 1 (cor hexadecimal + id da store view)

2° Talvês seja necessario limpar o cache do navegador, para vizualizar as informações.




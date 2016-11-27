# [Thomisticus RESTful Creator](http://tridiacriacao.com/clientes/ThomisticusRESTful/administrator/index.php?option=com_restful)

O Thomisticus RESTful é uma fábrica de Web Services e de envio Requests para servidores externos. A finalidade deste projeto é ter um componente instalável, para que através de uma interface gráfica amigável, seja possível a criação de WS's sem a necessidade de codificar novamente.
Isso é possível graças à abstração com a qual foi desenvolvido, poupando tempo de programadores.

O 'coração' do projeto pode ser encontrado nesta [pasta](https://github.com/Uniceub-Web-Development-2016-2/Igor-Moraes/tree/master/com_restful/ws):
```
/com_restful/ws
```

### Features
* Gerenciar os Resources (recursos/tabelas) e External Senders (envio para terceiros) por um painel administrativo
* Criar "de/paras" de campos para o relacionamento entre dois servidores
* Informar qual tipo de privilégio tal Resource terá [GET = Read | POST = Insert| PUT = Update | DELETE = Delete]
* [Mini-framework](https://github.com/Uniceub-Web-Development-2016-2/Igor-Moraes/tree/master/com_restful/ws/database) para CRUD, utilizando PDO e padrão Singleton
* [Trigger Factory](https://github.com/Uniceub-Web-Development-2016-2/Igor-Moraes/blob/master/com_restful/ws/database/Trigger.php) - [Cria as Triggers](https://github.com/Uniceub-Web-Development-2016-2/Igor-Moraes/blob/master/com_restful/administrator/models/externalsender.php#L214) no MySQL para as tabelas que deseja monitorar/enviar Requests para outro servidor. Assim, toda alteracão que for feita nas tabelas que estão sendo "escutadas", serão armazenadas numa tabela de log e em seguida a Request via HTTP será enviada.

## Ambiente

Será possível acessar a aplicação desenvolvida [NESTA URL](http://tridiacriacao.com/clientes/ThomisticusRESTful/administrator/index.php?option=com_restful) com os seguintes dados de acesso:
```
Nome de usuário: caio.silva
Senha: cebola
```
Apenas para fins práticos, o CMS Joomla! foi utilizado como facilitador na interface gráfica, porém toda engine/lógica por trás da fábrica de WS e Request Sender foi amplamente trabalhada em PHP puro.

### Testes
Para testar os envios de requests, [neste folder](https://github.com/Uniceub-Web-Development-2016-2/Igor-Moraes/tree/master/com_restful/ws/tests) disponibilzei alguns modelos de JSON para enviar como Request Body.
Esses podem ser enviados para a url: http://tridiacriacao.com/clientes/ThomisticusRESTful/ws/content

Tudo que vem depois de /ws é um resource, ou seja, o nome de uma tabela no banco de dados (desconsiderando o prefixo dessa). Caso necessite, fique a vontade de liberar novos resources.

### Melhorias e contribuição

Por dificuldades com infraestrutura/configuração, não foi possível otimizar o trabalho com as Threads do PHP, para monitorar a tabela de log e fazer o gatilho para envio de Requests. Contudo, para manter a assincronicidade dos processos, foi utilizado o AJAX.

Uma nova versão utilizando as Threads deverá ser desenvolvida e a solução via JavaScript deixada de lado.

### Desenvolvido com

* PHP 7.0.0
* JavaScript & jQuery
* HTML5/CSS3

## Autor

**Igor Sousa Guedes de Moraes** - RA: 21501099

Trabalho para aproveitamento da disciplina de *Desenvolvimento Web*, sob a supervisão do professor **Caio Melo Silva**.

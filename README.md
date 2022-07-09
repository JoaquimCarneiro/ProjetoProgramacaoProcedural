# Projeto Programação Procedural

IEFP EFA PRO - Programador de informática

## Introdução

Este projeto procura implementar os conhecimentos adquiridos no curso de programação EFA-Pro - Programador de Informática, lecionado pelo IEFP. Visto o curso não se ter limitado à programação, tendo nos sido dado também noções de redes e sistemas operativos, este projeto pretende implementar estes mesmos conhecimentos aqui adequiridos.

O projeto visa criar um ambiente de desenvolvimento e um sistema de _login_ programado em PHP. O ambiente de desenvolvimento será constituido por um servidor _web_, que terá como principal características a sua portabilidade, replicação e o qual tenta emular o funcionamento de um servidor de produção. O sistema de _login_ pretende implementar um sistema de registo e gestão de utilizadores e conteúdos, e irá criar uma base para a criação de futuros _websites_. 

### O Ambiente de desenvolvimento

O ambiente de desenvolvimento será constituido essencialmente por um servidor _web_, por um IDE e potencialmente um servidor de DNS. Será sempre dada prioridade a aplicar estas configurações usando tecnologias Opensource.

O servidor terá várias formas de implementação, podendo ser implementado como um servidor dedicado na rede local, na máquina de desenvolvimento em _localhost_, ou como uma máquina virtual ou contentor, localizado no computador de desenvolvimento ou num servidor na rede. A utilização de servidores virtuais tem como principais vantagens a facilidade de implementação, _backup_ e transporte. 

O servidor _web_ será constituido por uma pilha LAMP (Linux, Apache, MySql e PHP), o cliente MySql/MariaDB PhpMyAdmin, o gestor de servidores WebMin, o daemon SSH e o servidor de ficheiros Samba. A seguir descrevo as funcionalidades de cada um dos elementos do servidor:

- A pilha LAMP servirá de base para o desenvolvimento de _websites_ e é constituída pelo servidor _web_ Apache, o servidor de bases de dados MariaDB e o prórpio PHP que permitirá a programação e criação de _websites_ dinâmicos.
- O PhpMyAdmin serve para gerir e manipular as bases de dados a serem usadas nos projetos de uma forma visusal e simplificada.
- O WebMin serve para que a gestão e configurações do servidor possam ser feita de uma forma gráfica.
- O daemon SSH serve para se poder fazer ligação por consola ao servidor e para se poder montar o sistema de ficheiros a partir de SFTP ou SHHFS. A montagem de sistemas de ficheiros em Linux atravez de SSH é muito mais estável e permite taxas de tranferência e latência muito mais superiores às realizaveis atravez de um servidor de ficheiros Samba. Mas a sua utilidade não se limita a montar sistemas de ficheiros. Este devido a dar acesso total ao sistema operativo permite realizar configurações profundas no funcionamento do sistema. 
- O servidor de ficheiros samba serve para montar o sistema de ficheiros, sendo essencialmente utilizado para simplificar este processo com sistemas operativos Windows.

O servidor apache tem a funcionalidade de criar servidores virtuais com nomes de domínio dedicados (virtual-hosts). Mas para se aceder a estes pelo nome de domínio, é necessário configurar um servidor de DNS ou configurar o ficheiro hosts no sistema operativo cliente, evitando a configuração de mais um servidor. Estes ficheiros hosts encontram-se em /etc/hosts no Linux e em c:\Windows\System32\Drivers\etc\hosts

Toda esta integração é complementada usando o GIT localmente em conjunto com o GitHub.

Como IDE estou a usar o PhpStorm da Intelij, mas isto é somente uma opção pessoal. As principais razões da sua utilização são as suas otimizações para programar em PHP, a integração com GIT e a capacidade de funcionar em modo de desenvolvimento remoto a partir de uma ligação SSH.

Neste momento, estou a utilizar três configurações diferentes deste ambiente de desnvolvimento: uma máquina com o ambiente de trabalho em Linux e com um servidor dedicado na rede privada, um portátil com linux e com uma máquina virtual como servidor e um ambiente de trabalho em Windows com uma máquina virtual como servidor.

### O Sistema de _login_

O sistema de _login_  será constituido por um sistema de registo e controle de utilizadores, uma àrea de utilizador onde este poderá controlar os seus dados e informações pessoais, um sistema de níveis de acesso e permições, um _backoffice_ de administração, um sistema centralizado processamento de formulários e, futuramente, um sistema de criação de artigos e comentários.

O sistema funcionará como um _site_ de página única, utilizando a funcionalidade _Rewrite_ (mod_rewrite) do apache, que permite também "embelezar" os endereços das páginas e esconder os pedidos GET do _site_.

A programação limitar-se-á ao mínimo na utilização de _librarias_, _boilerplates_ e _bootstraps_. Esta limitação não significa de forma alguam a usa rejeição de utilização. Unicamente tem como intenção de que o sistema seja independente de terceiros. A unica exceção que aqui usada é a libraria para o envio de _emails_. Mas esta utilização não é sem razão. A libraria em questão é o [PHPMailer](https://github.com/PHPMailer/PHPMailer), que permite o envio de _emails_ por SMTP de uma forma segura e com autenticação. A sua utilização deve-se também ao facto de alguns ISPs, não permitirem a utilização da função nativa para envio de _emails_ do PHP ( _mail()_ ) para o envio de _emails_. 

Apesar disto, é da minha opinião que atualmente a utilização deste tipo de _librarias_ é feita de uma forma abusiva e não de uma forma funcional, resultando em que muitos _sites_ tenham uma pegada desnecessáriamente pesada no cliente do _site_.

## Implementação de funcionalidades do sistema de _login_

### _DONE_

- Formulários e _scripts_ de processamento para registo, _login_ e recuperação de palavras passe.
- Sistema de verificação de utilizadores atravéz de _email_ de confirmação.
- Gestão de identidade no _site_ através de Sessions.
- Verificação de campos de formulários e devolução de erros num só _script_.
- Envio de emails por SMTP (phpmailer).
- Implementação rudimentar de nível de utilizadores.
- Implementação de 'URLs limpos' atravéz de URL rewrite.
- Àrea de Utilizador básica.

### _TODO_

- verificação adicionais de campos de formulário de registo
  - tamanhos mínimos de campos
- Area de administração
- Area de utilizador
  - muiltiplos melhoramentos necessários
- Suporte para linguagens
- Suporte para cookies
- Sistema de artigos e comentários.
- Implementação e desenvolvimento do sistema em OOP e em paralelo com este sistema.
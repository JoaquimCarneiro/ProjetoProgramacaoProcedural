# Projeto Programação Procedural

IEFP EFA PRO - Programador de informática

## Introdução
Este projeto procura implementar os conhecimentos adquiridos no curso de programação EFA-Pro - Programador de Informática, lecionado pelo IEFP. Visto este curso não se ter limitado à programação, tendo nos sido também dado noções de redes e sistemas operativos, este projeto pretende implementar os conhecimentos adequiridos tanto na àrea da programação, como na àrea das redes e sistemas operativos.

O projeto visa criar um ambiênte de desenvolvimento e um sistema de _login_ em PHP. O ambiente de desenvolvimento será constituido por um servidor, que terá como principal características a sua portabilidade, replicação e a emolação de um servidor de produção. O sistema de _login_ pretende implementar um sistema de registo e gestão de utilizadores e conteúdos, e irá criar uma base para a criação de futuros _websites_. 

### O Ambiente de desenvolvimento
O ambiente de desenvolvimento será constituido essencialmente por um servidor _web_, por um IDE e potencialmente um servidor de DNS. Será sempre dada prioridade a aplicar estas configurações usando tecnologias Opensource.

O servidor terá várias formas de ser implementado. Poderá ser implementado como um servidor dedicado na rede local, na máquina de desenvolvimento em _localhost_, ou, numa máquina virtual ou contentor, localizado na própria máquina de desenvolvimento ou numa máquina na rede. A utilização de servidores virtuais tem como principais vantagens a facilidade de implementação, _backup_ e transporte. 

O servidor web será constituido por uma piha LAMP (Linux, Apache, MySql e PHP), o cliente sql PhpMyAdmin, o gestor de servidor WebMin, o daemon SSH e o servidor de ficheiros Samba. A seguir descrevo as funcionalidades de cada um dos elementos do servidor:
- A pilha LAMP servirá de base para o desenvolvimento de _websites_ e é constituída pelo servidor _web_ Apache, o servidor de bases de dados MariaDB e o prórpio PHP que permitirá a criação de _websites_ dinâmicos.
- O PhpMyAdmin serve para gerir e manipular as bases de dados a serem usadas nos projetos.
- O WebMin serve para que a gestão e configuração do servidor possa ser feita de uma forma gráfica.
- O daemon SSH serve para se poder fazer ligação por consola ao servidor e para se poder montar o sistema de ficheiros a partir de SFTP ou SHHFS.
- O servidor de ficheiros samba serve para montar o sistema de ficheiros, especialmente em sistemas windows.

O servidor apache tem a capacidade de criar servidores virtuais com nomes de domínio dedicados (virtual-hosts). Mas para se aceder a estes pelo nome de domínio, é necessário configurar um servidor de DNS ou configurar o ficheiro hosts no sistema operativo cliente. Estes ficheiros hosts encontram-se em /etc/hosts no Linux e em c:\Windows\System32\Drivers\etc\hosts

Como IDE estou a usar o PhpStorm da Intelij, mas isto é somente uma opção pessoal. As principais razões da sua utilização são as suas otimizações para programar com PHP, a integração com GIT e a capacidade de funcionar em modo de desenvolvimento remoto a partir de uma ligação SSH.

Neste momento, estou a utilizar três configurações diferentes deste ambiente de desnvolvimento: uma máquina com o ambiente de trabalho em Linux com um servidor dedicado na rede, um portátil em linux com uma máquina virtual como servidor e um ambiente de trabalho em Windows com uma máquina virtual como servidor.

### O Sistema de _login_
O sistema de _login_  será constituido por um sistema de registo e controle de utilizadores, uma àrea de utilizador onde este poderá controlar os seus dados e informações, níveis de acesso e permições dos utilizadores, um _backoffice_ de administração, um sistema centralizado processamento de formulários e futuramente um sistema de criação de artigos e comentários.

O sistema funcionará como um _site_ de página única, utilizando a funcionalidade _Rewrite_ (mod_rewrite) do apache, que permite também "embelezar" os endereços das páginas e esconder os pedidos GET do site.

A programação limitará ao mínimo a utilização de _librarias_, _boilerplates_ e _bootstraps_. Esta limitação não significa rejeição da utilização, unicamente faz com que o sistema seja independente de terceiros. É da minha opinião que atualmente a utilização deste tipo de _librarias_ é feita de uma forma abusiva e não de uma forma funcional, resultando em que muitos _sites_ tenham uma pegada desnecessáriamente pesada no cliente do _site_. A unica exceção que etou a usar é a libraria para o envio de _emails_, e esta utilização não é sem razão. A libraria em questão é o [PHPMailer](https://github.com/PHPMailer/PHPMailer), que permite o envio de emails por SMTP de uma forma segura e com autenticação. A sua utilização deve-se também ao facto de alguns ISPs, não permitirem a utilização da função nativa para envio de _emails_ do PHP ( _mail()_ ) para o envio de _emails_.  

## Implementação de funcionalidades do sistema de _login_
### DONE
- Formulários e processamento para registo, login e recuperação de passwords.
- Script de verificação de utilizadores
- Login através de Sessions.
- verificação de campos de formulários e devolução de erros.
- Envio de emails por SMTP (phpmailer)
- Implementação rodimentar de nível de utilizadores
- Implementação de 'URLs limpos' através de URL rewrite

### TODO
- verificação adicionais de campos de formulário de registo
  - tamanhos mínimos de campos
- Area de administração
- Area de utilizador
- Suporte para linguagens
- Suporte para cookies
- ...!!!
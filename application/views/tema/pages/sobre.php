<?php $this->load->view('tema/header'); ?>

<h2><?php if(!empty($title)) echo $title; ?></h2>



<div class=WordSection1>

<h3 style="text-align: center;">Criação de um Repositório de Dados Ligados para Filtragem de <i>Hoax</i></h3>

<p style="text-align:center;">Jairo Francisco de Souza</p>

<p style="text-align:center;">Departamento de Ciência da Computação – Universidade Federal de Juiz de Fora (UFJF)</p>

<p style="text-align:center;">jairo.souza@ufjf.edu.br</p>

</div>

<div class=WordSection2>

<p class=Abstract><b>Abstract.</b> <span lang=EN-US>This project shows the use
of linked data to provide a way to represent and consume information. This
technology aims to create a knowledge base from multiple interlinked domains
allowing to perform complex queries. By using linked data it is possible to
create intelligent systems for consuming and analyzing semantic information. A
tool was created to mark as spam messages about unmissing people on Facebook,
using a database that implements the linked data principles.</span></p>

<p class=Abstract><b>Resumo.</b> Este projeto exemplifica o uso de dados
ligados para fornecer um mecanismo de representação e consumo de informações.
Esta tecnologia visa a criação de centros de dados para vários domínios que
podem interagir através de ligações entre diferentes entidades na web, tornando
possível a realização de consultas detalhadas. Utilizando esta abordagem
torna-se possível a criação de aplicações mais inteligentes que podem consumir
e analisar estes dados. Para este projeto foi criada uma ferramenta que auxilia
na identificação de mensagens falsas de pessoas desaparecidas no Facebook,
utilizando uma base de dados que segue os princípios de dados ligados. </p>

<h2>1. Introdução</h2>

<p class=MsoNormal>A chegada da <i>web</i> 2.0 trouxe mais dinâmica para a
disponibilização de conteúdo, possibilitando que qualquer usuário publique conteúdo
de maneira simples, sem a necessidade de conhecimento avançado em informática. 
As ferramentas para criação de blogs estão se tornando cada vez mais práticas e
acessíveis ao usuário leigo, de forma que as pessoas possam se preocupar mais com
a qualidade da informação.</p>

<p class=MsoNormal>As redes sociais também se destacam entre os
meios de geração de conteúdo, sendo um ambiente onde as pessoas postam
informações variadas e compartilham com amigos, atingindo milhares de usuários.
Junto às redes sociais o número de dispositivos conectados à internet cresceu
consideravelmente. Hoje, existem <i>notebooks</i>, <i>smartphones</i>, <i>tablets</i>
e até celulares mais simples com acesso a internet, prontos para que o usuário
possa interagir nas redes sociais. Com todas essas tecnologias em mãos pode-se
dizer que este perfil de usuário se torna o principal criador de conteúdo na <i>web</i>.</p>

<p class=MsoNormal>O crescimento de informações e o fato de
qualquer pessoa ser capaz de postar dados sem a certeza de sua validade é um
fator preocupante. Atualmente, circulam entre as redes sociais mensagens
conhecidas como <i>hoax</i>, que procuram sensibilizar usuários a compartilhar
informações falsas, formando correntes entre milhares de pessoas (Teixeira, 2007).
Dentre as <i>hoax </i>existentes, as mensagens de pessoas desaparecidas são
cada vez mais constantes. O uso das redes sociais para encontrar pessoas é uma
estratégia válida e que pode realmente ajudar. Porém, a falta de um mecanismo
para eliminar estas mensagens após encontrar o indivíduo, proporciona a propagação
de conteúdo falso, sendo um incômodo para os usuários e principalmente para a
família que passa a ser vítima de informações falsas.</p>

<p class=MsoNormal>Dentro deste cenário, este projeto possui como
objetivo geral contribuir com a criação de um banco de dados com informações de
pessoas desaparecidas, capaz de ajudar a identificar possíveis <i>hoaxes</i>,
evitando que usuários sejam enganados. </p>

<p class=MsoNormal>Como objetivo específico o projeto propõe a
implementação de uma abordagem para identificação automática de conteúdo sobre
pessoas desaparecidas em um ambiente muito utilizado atualmente, as redes
sociais. Automatizando este processo, uma aplicação criada poderá evitar que
usuários destes serviços repassem mensagens falsas para sua rede de amigos.</p>

<h2>2. Dados de pessoas desaparecidas</h2>

<p>No Brasil as Organizações Não Governamentais são as principais atuantes na busca
por pessoas desaparecidas junto às famílias. As ONGs utilizam amplamente a <i>Web</i>
como um meio para a divulgação de casos de desaparecimentos por atingir um
grande número de pessoas. Para estes casos, as informações estão limitadas a
documentos HTML simples e de fácil visualização, mas que dificultam o
processamento por máquina. Uma vez que os dados não se encontram estruturados,
torna-se difícil para qualquer aplicação extrair conteúdos pertinentes das páginas.
Outro aspecto importante é que os sites que tratam destes assuntos agem de
forma independente, cada um com sua própria base, sendo possível a ocorrência
de informações duplicadas.</p>

<p>Como as ONGs são entidades filantrópicas, em muitos dos casos faltam recursos para
manter uma equipe capaz de trabalhar com a manutenção dos dados. As informações
na <i>Web</i> nem sempre estão atualizadas. Uma dificuldade do projeto está no
acesso e reunião dos dados necessários. Durante o trabalho diversas buscas por
informações de pessoas desaparecidas foram feitas e poucos foram os <i>sites</i>
com dados atualizados disponíveis.</p>

<h2>3. Dados Ligados</h2>

<p class=MsoNormal>De acordo com Berners-Lee (2006) a <i>Web</i> Semântica não
se resume somente em colocar dados na <i>web</i>. Sua proposta é realizar
ligações entre os dados de forma que pessoas e máquinas possam reutilizá-los.
Com os dados ligados entre si é possível, a partir de alguma informação,
atingir outros dados relacionados.</p>

<p class=MsoNormal>Bizer &amp; Heath (2009) definem Dados Ligados
simplesmente como sendo uma forma de utilizar a <i>web</i> para criar ligações
entre os dados de acordo com seus tipos. Como estes dados estão publicados na <i>web</i>
podem-se encontrar fontes de informações em bancos de dados externos, em
diferentes posições geográficas e legíveis por máquinas, uma vez que o significado
dos dados é explícito.</p>

<p class=MsoNormal>No caso da <i>web</i> de documentos as unidades
primárias são documentos HTML com links para outros documentos. Para compor a <i>Web</i>
de Dados Ligados, os recursos são representados através de um formato padrão, o
RDF (W3C-RDF, 2004), que permite interligar entidades de diferentes domínios (Bizer
&amp; Heath, 2009).</p>

<p class=MsoNormal>Berners-Lee (2006) definiu quatro princípios que
regem a publicação de dados utilizando a tecnologia de dados ligados na <i>web</i>:</p>

<p class=MsoNormal>1.         Utilize uma URI para identificar qualquer recurso;</p>

<p class=MsoNormal>2.         Sempre use URIs HTTP para que seja possível
encontrar estes nomes na <i>web</i>;</p>

<p class=MsoNormal>3.         Forneça os dados utilizando um formato padrão,
RDF e SPARQL (W3C-SPARQL, 2008);</p>

<p class=MsoNormal>4.         Crie ligações para outros recursos na <i>web</i>
de forma que seja possível encontrar mais informações.</p>

<p class=MsoNormal>Estes princípios fornecem um mecanismo para
publicação e conexão entre dados usando a infra-estrutura da <i>web</i> (Heath
as all, 2009)<b>.</b></p>

<p class=MsoNormal style='text-indent:.05pt'>Atualmente, existem
vários projetos como o Wikipedia, Wikibooks, Geonames, que disponibilizam
conteúdos livres na <i>web</i>. O projeto <i>Linking Open Data</i>, criado pela
W3C SWEO, surgiu para incentivar a publicação de <i>datasets</i> em RDF,
atribuindo ligações entre dados de diferentes fontes (W3C-SWEO, 2012).</p>

<p class=MsoNormal>Inicialmente o projeto contou com o apoio de
pesquisadores, desenvolvedores e pequenas empresas. Com o tempo, ganhou
proporções maiores e atingiu grandes organizações, principalmente devido seu
caráter público, onde qualquer pessoa pode contribuir fornecendo um conjunto de
dados seguindo os princípios de dados ligados (Bizer &amp; Heath, 2009). A figura
1 mostra uma representação dos <i>datasets</i> criados e as respectivas
ligações entre eles:</p>

<p class=MsoNormal align=center style='text-align:center'><img
width=552 height=217
src="<?php echo base_url() ?>/images/artigo/image002.jpg"></p>

<p class=MsoNormal align=center style='text-align:center;line-height:150%'><b><span
style='font-size:10.0pt;line-height:150%;font-family:"Helvetica","sans-serif"'>Figura
1. Diagrama do projeto Linking Open Data.</span></b></p>

<p class=MsoNormal>O grafo representado na figura 1 apresenta uma
centena de <i>datasets</i>, porém somente dois contém informações em português.
O DBPedia<a href="#_ftn1" name="_ftnref1" title=""><span
class=MsoFootnoteReference><span class=MsoFootnoteReference><span>[1]</span></span></span></a> 
surgiu como um projeto cujo objetivo é mapear os dados da Wikipédia e
oferecê-los no formato de dados ligados. Este trabalho contou com a ajuda de
vários países inclusive do Brasil, em que o Departamento de Ciência da
Computação da Universidade Federal de Juiz de Fora contribuiu para o mapeamento
dos dados em português. Outro projeto de destaque é o trabalho que surgiu
também no Departamento de Ciência da Computação da UFJF que criou um novo <i>dataset</i>
para o projeto <i>Linking Open Data</i> com informações de políticos
brasileiros, o Ligado nos Políticos<a href="#_ftn2" name="_ftnref2" title=""><span
class=MsoFootnoteReference><span class=MsoFootnoteReference><span>[2]</span></span></span></a>.<b> </b></p>

<h2>4. Criação de um <i>dataset</i> de pessoas desaparecidas</h2>

<p class=MsoNormal>Para formar um <i>dataset</i> de pessoas desaparecidas foi
necessário inicialmente recolher dados na <i>web</i>. Como não existem informações
em formatos abertos utilizaram-se os dados disponíveis em sites de ONGs. O
método utilizado escolhido para obter os dados é chamado de raspagem de dados.
Através deste mecanismo, um <i>script</i> conhecido como <i>web crawler</i>
acessa o HTML das páginas e retira o conteúdo de acordo com as especificações
do desenvolvedor.</p>

<p class=MsoNormal>Os dados obtidos foram armazenados em um banco
relacional e mapeados para um formato aberto e disponível para consultas.
Objetivando facilitar e otimizar a formação do <i>dataset</i> utilizou-se uma
tecnologia chamada Virtuoso, um software criado para atuar como um servidor
universal que comporte as mais variadas tecnologias, incluindo servidor <i>web</i>,
servidor de arquivos, banco de dados e armazenamento de XML nativo, disponíveis
em uma única ferramenta. É possível trabalhar com o gerenciamento de bancos de
dados relacionais e de dados no formato RDF e XML, como mencionado
anteriormente possui um servidor <i>web</i> além de um servidor de Dados
Ligados e de aplicações <i>web</i>. Outra característica importante é a possibilidade
de trabalhar com Serviços <i>Web</i>, SOAP ou REST (OpenLink-Documentation,
2008).</p>

<p class=MsoNormal>Criou-se também um site para exibir os dados no
formato HTML e RDF, http://desaparecidos.ice.ufjf.br. Os dados das pessoas
desaparecidas ficam acessíveis através de um identificador, gerado de acordo
com os princípios de dados ligados, uma URI HTTP. Toda URI deve ser
dereferenciável, ou seja, o cliente pode utilizar um protocolo HTTP e obter
informações relacionadas ao recurso identificado pela URI. A informação
retornada depende do cliente que fez a requisição, para seres humanos uma
representação HTML seria mais apropriada, enquanto para aplicações que consomem
dados, o uso do padrão RDF é indicado (Heath &amp; Bizer, 2011). </p>

<p class=MsoNormal> Para a representação RDF foram reaproveitadas
algumas ontologias como <i>foaf</i><a href="#_ftn3" name="_ftnref3" title=""><span
class=MsoFootnoteReference><span class=MsoFootnoteReference><span>[3]</span></span></span></a>
para descrição de pessoas, <i>geonames</i><a href="#_ftn4" name="_ftnref4"
title=""><span class=MsoFootnoteReference><span class=MsoFootnoteReference><span>[4]</span></span></span></a>
para dados de localização, e <i>dbpprop</i><a href="#_ftn5" name="_ftnref5"
title=""><span class=MsoFootnoteReference><span class=MsoFootnoteReference><span>[5]</span></span></span></a>
para descrever características físicas. Propriedades importantes para descrever
pessoas desaparecidas como data de localização e a situação do indivíduo, foram
criadas originando uma nova ontologia nomeada como <i>des</i>. </p>

<p class=MsoNormal>Um dos princípios dos dados ligados requer que
as informações estejam conectadas entre si. No intuito de satisfazer esta
condição foi necessário estabelecer ligações entre os dados de desaparecidos
com outras bases existentes. Para este caso utilizaram-se dados de localização
e a fonte em que a informação foi retirada.</p>

<p class=MsoNormal>A figura 2 ilustra de forma simplificada os processos
envolvidos desde a coleta de informações até a geração dos dados em formato
aberto.</p>

<p class=MsoNormal align=center style='text-align:center'><img width=503
height=229
src="<?php echo base_url() ?>/images/artigo/image003.jpg"></p>

<p class=MsoNormal align=center style='text-align:center;line-height:150%'><b><span
style='font-size:10.0pt;line-height:150%;font-family:"Helvetica","sans-serif"'>Figura
2. Esquema do processo de criação da base de dados ligados</span></b></p>

<h2>5. Aplicação para redes sociais</h2>

<p class=MsoNormal>Com um repositório de informações abertas a disposição
torna-se mais fácil a criação de aplicações. O problema identificado é a
propagação de <i>hoax</i> nas redes sociais e a falta de praticidade em
descobrir a validade destas mensagens. Para este cenário uma aplicação poderia
contribuir reduzindo os compartilhamentos desnecessários.</p>

<p class=MsoNormal>Sugeriu-se para este projeto o desenvolvimento
de uma aplicação <i>web mobile</i> capaz de acessar dados do mural de usuários no
Facebook e, através de uma interface simples, retornar a situação de um
indivíduo e informações mais detalhadas.</p>

<p class=MsoNormal>O Facebook disponibiliza uma API para que os
desenvolvedores criem aplicações e obtenham dados de usuários da rede social.
Ao acessar as atualizações do mural é possível utilizar técnicas para
identificar possíveis mensagens de pessoas desaparecidas. Neste caso, optou-se
por utilizar um <i>array</i> de <i>tokens</i>. A escolha dos melhores <i>tokens</i>
foi realizada com o apoio de uma técnica chamada s<i>temming</i>, que propõe um
conjunto de etapas para chegar a um termo comum, eliminando os fatores que
geram variações. Um exemplo é a palavra “desaparecido”, que pode aparecer em
diversas postagens sofrendo variações. Aplicando o algoritmo <i>stemming,</i> o
<i>token</i> para busca passa a ser somente “desaparec”.</p>

<p class=MsoNormal>Ao identificar uma postagem como sendo de um
desaparecido, a aplicação verifica a ocorrência desta pessoa na base. O
Virtuoso oferece uma interface REST, acessível através do protocolo HTTP, onde
é possível enviar uma consulta SPARQL e ter como resultado um XML com o
resultado.</p>

<p>Para
reduzir o conteúdo a ser processado utilizou-se uma técnica conhecida como s<i>top
words</i>.  Comum entre os mecanismos de buscas esta técnica propõe a remoção
de palavras não relevantes em uma pesquisa, com o objetivo de simplificar a
consulta e reduzir o tempo de resposta (Rouse, 2005). As <i>stop words</i> são
artigos, preposições, pronomes, entre outras. A lista de <i>stop words</i>
utilizada para o projeto encontra-se acessível em http://snowball.tartarus.org/algorithms/portuguese/stop.txt.</p>

<p class=MsoNormal>A sequência de termos resultantes, agora
simplificada, é analisada para retirar possíveis nomes próprios. Como os nomes
são encontrados entre os textos iniciando, na maioria das vezes, com a letra
maiúscula, criou-se um algoritmo que fizesse esta verificação e guardasse tais
nomes. Por fim, os nomes encontrados são utilizados na consulta realizada na
base criada.</p>

<p class=MsoNormal>Caso a pessoa seja encontrada, o sistema exibe o
status do indivíduo para o usuário. Se ela não existir, o usuário pode acessar
o site do projeto e contribuir com informações que ajudem a encontrá-la,
permitindo assim ampliar o banco de dados sem que as informações fiquem
atreladas somente aos dados de ONGs. A figura 3 mostra a aplicação em execução:</p>

<h1><img style="display:block;margin:0 auto;" width=566 height=329
src="<?php echo base_url() ?>/images/artigo/image004.jpg"></h1>

<h1 align=center style='text-align:center;line-height:150%'><span
style='font-size:10.0pt;line-height:150%;font-family:"Helvetica","sans-serif"'>Figura
3. Aplicação <i>Web mobile</i></span></h1>

<h2>6. Conclusão</h2>

<p class=MsoNormal>Este projeto possui como resultado a inclusão de um novo <i>dataset</i>
com informações de pessoas desaparecidas seguindo os princípios de dados
ligados, a fim de contribuir com o projeto <i>Linking Open Data</i>. Esta nuvem
de dados permite que desenvolvedores coletem e manipulem dados semânticos para
serem utilizados em aplicações diversas. O formato padronizado e livre
associado ao crescente número de domínios que estão sendo incluídos favorece o
surgimento de aplicações cada vez mais inteligentes e capazes de trabalhar com
informações interligadas na <i>web</i>. </p>

<p class=MsoNormal>Além da criação desta base, a proposta também
incluiu o desenvolvimento de uma aplicação capaz de exemplificar o uso destes
dados em um caso prático, a identificação de pessoas desaparecidas.</p>

<p class=MsoNormal> Além de representar um caráter social, ajudando
famílias que possuem parentes desaparecidos, a aplicação também ajudará a
reduzir o número de compartilhamento de <i>hoax </i>nas redes sociais.</p>

<h2>Referências</h2>

<p class=Reference>Teixeira, R. C. (2007) <b>Boatos (Hoax)</b>. Disponível em: <a
href="http://informatica.terra.com.br/virusecia/spam/interna/0,,OI198466-EI2403,00.html">http://informatica.terra.com.br/virusecia/spam/interna/0,,OI198466-EI2403,00.html</a>
[Online; acessado em 01-10-2012]</p>

<p class=Reference><span lang=EN-US>Berners-Lee (2006) T. <b>Linked data</b>. </span>Disponível
em: &lt;<a href="http://www.w3.org/DesignIssues/LinkedData.html">http://www.w3.org/DesignIssues/LinkedData.html</a>&gt;
[Online; acessado em 12-agosto-2012].</p>

<p class=Reference><span lang=EN-US>Heath, T.; Hepp, M.; Bizer, C. (2009) <b>Linked
data - the story so far</b>. </span>Disponível em:
&lt;http://tomheath.com/papers/bizer-heath-berners-lee-ijswis-linked-data.pdf&gt;
[Online; acessado em 31-junho-2012].</p>

<p class=Reference><span lang=EN-US>W3C-SWEO (2012) <b>W3C SWEO Community
Project</b>. </span>Disponível em: &lt;http://www.w3.org/wiki/SweoIG/TaskForces/CommunityProjects/LinkingOpenData&gt;</p>

<p class=Reference><span lang=EN-US>LOD (2012) <b>Linked Data - Connect
Distributed Data across the <i>Web</i></b>. </span>Disponível em:
&lt;http://linkeddata.org&gt; [Online; acessado em 12-agosto-2012]</p>

<p class=Reference><span lang=EN-US>W3C-RDF (2004)  <b>Resource Description
Framework (RDF)</b>. </span>Disponível em: &lt;http://www.w3.org/RDF/&gt; [Online;
acessado em 15-agosto-2012]</p>

<p class=Reference><span lang=EN-US>W3C-SPARQL  (2008) <b> SPARQL Query
Language for RDF</b>. </span>Disponível em:
&lt;http://www.w3.org/TR/rdf-sparql-query/&gt; [Online; acessado em
15-agosto-2012]</p>

<p class=Reference><span lang=EN-US>OpenLink-Documentation (2008) <b>OpenLink
Virtuoso Universal Server: Documentation</b>, OpenLink Software Documentation
Team. </span>Disponível em: <a
href="http://docs.openlinksw.com/pdf/virtdocs.pdf">http://docs.openlinksw.com/pdf/virtdocs.pdf</a>
[Online; acessado em 15-agosto-2012]</p>

<p class=Reference><span lang=EN-US>Heath, T.; Bizer, Y. (2011) <b>Linked Data:
Evolving the Web into a Global Data Space (1st edition)</b>. Synthesis Lectures
on the Semantic Web: Theory and Technology, 1:1, 1-136. </span>Morgan &amp;
Claypool. Disponível em: <span lang=EN-US><a
href="http://linkeddatabook.com/editions/1.0/"><span lang=PT-BR>http://linkeddatabook.com/editions/1.0/</span></a></span>
[Online; acessado em 15-agosto-2012]</p>

<p class=Reference><span lang=EN-US>Orengo, V. M.; Huyck, C. (2001) <b>A
Stemming Algorithm for the Portuguese Language</b></span></p>

<p class=Reference><span lang=EN-US>Rouse, M. (2005) <b>Definition: Stop word</b>.
</span>Disponível em: &lt;<span lang=EN-US><a
href="http://searchsoa.techtarget.com/definition/stop-word"><span lang=PT-BR>http://searchsoa.techtarget.com/definition/stop-word</span></a></span>&gt;
[Online; acessado em 02-outubro-2012]</p>

</div>

<div><br clear=all>

<hr align=left size=1 width="33%">

<div id=ftn1>

<p class=MsoFootnoteText><a href="#_ftnref1" name="_ftn1" title=""><span
class=MsoFootnoteReference><span lang=EN-US><span class=MsoFootnoteReference><span
lang=EN-US style='font-size:10.0pt;font-family:"Times","serif"'>[1]</span></span></span></span></a><span
lang=EN-US> http://pt.dbpedia.org/ </span></p>

</div>

<div id=ftn2>

<p class=MsoFootnoteText><a href="#_ftnref2" name="_ftn2" title=""><span
class=MsoFootnoteReference><span lang=EN-US><span class=MsoFootnoteReference><span
lang=EN-US style='font-size:10.0pt;font-family:"Times","serif"'>[2]</span></span></span></span></a><span
lang=EN-US> http://ligadonospoliticos.com.br</span></p>

</div>

<div id=ftn3>

<p class=MsoFootnoteText><a href="#_ftnref3" name="_ftn3" title=""><span
class=MsoFootnoteReference><span lang=EN-US><span class=MsoFootnoteReference><span
lang=EN-US style='font-size:10.0pt;font-family:"Times","serif"'>[3]</span></span></span></span></a>
http://www.foaf-project.org/</p>

</div>

<div id=ftn4>

<p class=MsoFootnoteText><a href="#_ftnref4" name="_ftn4" title=""><span
class=MsoFootnoteReference><span lang=EN-US><span class=MsoFootnoteReference><span
lang=EN-US style='font-size:10.0pt;font-family:"Times","serif"'>[4]</span></span></span></span></a><span
lang=EN-US> http://www.geonames.org/</span></p>

</div>

<div id=ftn5>

<p class=MsoFootnoteText><a href="#_ftnref5" name="_ftn5" title=""><span
class=MsoFootnoteReference><span lang=EN-US><span class=MsoFootnoteReference><span
lang=EN-US style='font-size:10.0pt;font-family:"Times","serif"'>[5]</span></span></span></span></a><span
lang=EN-US> http://dbpedia.org/</span></p>

</div>

</div>


<div class="download">
    <a target="_blank" href="<?php echo base_url(); ?>documentos/artigo.pdf" title="Download do PDF do projeto">Download do PDF do projeto.</a>
</div>

<?php $this->load->view('tema/footer'); ?>

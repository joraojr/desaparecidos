grant select on "DES"."DBA"."Desaparecido" to SPARQL_SELECT;


SPARQL
prefix DES: <http://desaparecidos.ice.ufjf.br/desaparecido/> 
create iri class DES:desaparecido "http://^{URIQADefaultHost}^/DES/desaparecido/id/%d#this" (in _id integer not null) . ;


SPARQL
prefix DES: <http://desaparecidos.ice.ufjf.br/desaparecido/> 
prefix aowl: <http://bblfish.net/work/atom-owl/2006-06-06/> 
prefix foaf: <http://xmlns.com/foaf/0.1/>
prefix dbpprop: <http://dbpedia.org/property/>
prefix being: <http://purl.org/ontomedia/ext/common/being#>
alter quad storage virtrdf:DefaultQuadStorage 
 from "DES"."DBA"."Desaparecido" as desaparecido_s
 { 
   create DES:qm-desaparecido as graph iri ("http://^{URIQADefaultHost}^/DES#") option (exclusive) 
    { 
      # Maps from columns of "DES.DBA.Desaparecido"
      DES:desaparecido (desaparecido_s."id")  a DES:Desaparecido ;
      DES:id desaparecido_s."id" as DES:dba-desaparecido-id ;
      foaf:name desaparecido_s."nome" as DES:dba-desaparecido-nome ;
      foaf:nick desaparecido_s."apelido" as DES:dba-desaparecido-apelido ;
      foaf:birthday desaparecido_s."data_nascimento" as DES:dba-desaparecido-data_nascimento ;
      foaf:gender desaparecido_s."sexo" as DES:dba-desaparecido-sexo ;
      foaf:img desaparecido_s."imagem" as DES:dba-desaparecido-imagem ;
      foaf:age desaparecido_s."idade" as DES:dba-desaparecido-idade ;
      DES:cityDes desaparecido_s."cidade" as DES:dba-desaparecido-cidade ;
      DES:stateDes desaparecido_s."estado" as DES:dba-desaparecido-estado ;
      dbpprop:height desaparecido_s."altura" as DES:dba-desaparecido-altura ;
      dbpprop:weight desaparecido_s."peso" as DES:dba-desaparecido-peso ;
      DES:skin desaparecido_s."pele" as DES:dba-desaparecido-pele ;
      dbpprop:hairColor desaparecido_s."cor_cabelo" as DES:dba-desaparecido-cor_cabelo ;
      dbpprop:eyeColor desaparecido_s."cor_olhos" as DES:dba-desaparecido-cor_olhos ;
      DES:moreCharacteristics desaparecido_s."caracteristicas_diversas" as DES:dba-desaparecido-caracteristicas_diversas ;
      DES:disappearanceDate desaparecido_s."data_desaparecimento" as DES:dba-desaparecido-data_desaparecimento ;
      DES:disappearancePlace desaparecido_s."local_desaparecimento" as DES:dba-desaparecido-local_desaparecimento ;
      DES:circumstanceLocation desaparecido_s."circunstancia_localizacao" as DES:dba-desaparecido-circunstancia_localizacao ;
      DES:dateLocation desaparecido_s."data_localizacao" as DES:dba-desaparecido-data_localizacao ;
      DES:additionalData desaparecido_s."dados_complementares" as DES:dba-desaparecido-dados_complementares ;
      DES:status desaparecido_s."situacao" as DES:dba-desaparecido-situacao ;
      DES:source desaparecido_s."fonte" as DES:dba-desaparecido-fonte .

    }
 }

;



DB.DBA.URLREWRITE_CREATE_REGEX_RULE (
'des_rule2',
1,
'(/[^#]*)',
vector('path'),
1,
'/sparql?query=DESCRIBE+%%3Chttp%%3A//^{URIQADefaultHost}^%U%%23this%%3E+FROM+%%3Chttp%%3A//^{URIQADefaultHost}^/DES%%23%%3E&format=%U',
vector('path', '*accept*'),
null,
'(text/rdf.n3)|(application/rdf.xml)',
2,
null
);
DB.DBA.URLREWRITE_CREATE_REGEX_RULE (
'des_rule4',
1,
'/DES/stat([^#]*)',
vector('path'),
1,
'/sparql?query=DESCRIBE+%%3Chttp%%3A//^{URIQADefaultHost}^/DES/stat%%23%%3E+%%3Fo+FROM+%%3Chttp%%3A//^{URIQADefaultHost}^/DES%%23%%3E+WHERE+{+%%3Chttp%%3A//^{URIQADefaultHost}^/DES/stat%%23%%3E+%%3Fp+%%3Fo+}&format=%U',
vector('*accept*'),
null,
'(text/rdf.n3)|(application/rdf.xml)',
2,
null
);
DB.DBA.URLREWRITE_CREATE_REGEX_RULE (
'des_rule6',
1,
'/DES/objects/([^#]*)',
vector('path'),
1,
'/sparql?query=DESCRIBE+%%3Chttp%%3A//^{URIQADefaultHost}^/DES/objects/%U%%3E+FROM+%%3Chttp%%3A//^{URIQADefaultHost}^/DES%%23%%3E&format=%U',
vector('path', '*accept*'),
null,
'(text/rdf.n3)|(application/rdf.xml)',
2,
null
);
DB.DBA.URLREWRITE_CREATE_REGEX_RULE (
'des_rule1',
1,
'([^#]*)',
vector('path'),
1,
'/about/html/http://^{URIQADefaultHost}^%s',
vector('path'),
null,
null,
2,
303
);
DB.DBA.URLREWRITE_CREATE_REGEX_RULE (
'des_rule5',
1,
'/DES/objects/(.*)',
vector('path'),
1,
'/services/rdf/object.binary?path=%%2FDES%%2Fobjects%%2F%U&accept=%U',
vector('path', '*accept*'),
null,
null,
2,
null
);
DB.DBA.URLREWRITE_CREATE_RULELIST ( 'des_rule_list1', 1, vector ( 'des_rule1', 'des_rule5', 'des_rule2', 'des_rule4', 'des_rule6'));
DB.DBA.VHOST_REMOVE (lpath=>'/DES');
DB.DBA.VHOST_DEFINE (lpath=>'/DES', ppath=>'/', vsp_user=>'dba', is_dav=>0,
is_brws=>0, opts=>vector ('url_rewrite', 'des_rule_list1')
);
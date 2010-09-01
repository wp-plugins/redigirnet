<?php
  /*
  Plugin Name: Redigir.net
  Plugin URI: http://redigir.net
  Description: Plugin usado para fazer a interacção com a plataforma Redigir.net
  Author: Ricardo Silva
  Version: 0.6
  Author URI: http://redigir.net
  */
  define('REDIGIR_PATH',PLUGINDIR.'/redigirnet/');
  define('REDIGIR_VERSION','0.6');            
  add_action('admin_menu','redigir_add_menu_items');
  add_action('admin_init','redigir_register_buyer');          

  // Register a new buyer
  function redigir_register_buyer(){      
      // Check if this blog is already registered
      if ( get_option('redigir_user_id',false) === false || get_option('redigir_user_id',false) == 0 ){                              
          $token = md5(time());          
          $args = array(
              'timeout' => 3,
              'body' => array ('token'=>$token,'email'=>get_option('admin_email'),'name'=>get_option('blogname')),
              'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )
          );

          $redigir_user_id = wp_remote_retrieve_body(wp_remote_post('http://redigir.net/api/register_buyer',$args));          
          if ( get_option('redigir_user_id',false) === false ){
              add_option('redigir_user_id',intval($redigir_user_id),'','no');
          }          
          else {
              update_option('redigir_user_id',intval($redigir_user_id));
          }

          add_option('redigir_token',$token,'','no');
      }
  }     

  // Get all the categories
  function redigir_get_categories(){                       



      return unserialize(wp_remote_retrieve_body(wp_remote_get('http://redigir.net/api/get_categories')));



  }



  



  function redigir_get_authors(){



      $args = array(



          'timeout' => 3,



          'body' => array ('token'=>get_option('redigir_token'),'user_id'=>get_option('redigir_user_id')),



          'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )



      );                                                



      $us = unserialize(wp_remote_retrieve_body(wp_remote_post('http://redigir.net/api/get_authors',$args)));



      return $us;  



  }



  



  // Get an article



  function redigir_get_article($article_id){



      $args = array(



          'timeout' => 3,



          'body' => array ('article_id'=>$article_id,'token'=>get_option('redigir_token'),'user_id'=>get_option('redigir_user_id')),



          'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )



      );                                    



      $a = unserialize(wp_remote_retrieve_body(wp_remote_post('http://redigir.net/api/get_article',$args)));



      return $a;   



  }  



  



  // Get all the categories



  function redigir_get_pending_articles(){                       



      $args = array(



          'timeout' => 3,



          'body' => array ('token'=>get_option('redigir_token'),'user_id'=>get_option('redigir_user_id')),



          'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )



      );                                    



      $as = unserialize(wp_remote_retrieve_body(wp_remote_post('http://redigir.net/api/get_pending_articles',$args)));      



      return $as;      



  }  



  



  // Ge the funds for this buyer



  function redigir_get_funds(){



      $args = array(



          'timeout' => 3,



          'body' => array ('token'=>get_option('redigir_token'),'user_id'=>get_option('redigir_user_id')),



          'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )



      );



                                    



      $funds = wp_remote_retrieve_body(wp_remote_post('http://redigir.net/api/get_funds',$args));



      return $funds;  



  }



  



  // Ge the funds for this buyer



  function redigir_get_version(){



      $args = array(



          'timeout' => 3,



          'body' => array ('token'=>get_option('redigir_token'),'user_id'=>get_option('redigir_user_id')),



          'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )



      );



                                    



      $res = wp_remote_retrieve_body(wp_remote_post('http://redigir.net/api/get_version',$res));



      return $res;  



  }  



  



  // Create a new article



  function redigir_article_add(){



      $args = array(



          'timeout' => 3,



          'body' => array ('source1'=>$_POST['source1'],'source2'=>$_POST['source2'],'source3'=>$_POST['source3'],'source4'=>$_POST['source4'],'source5'=>$_POST['source5'],'words'=>$_POST['words'],'title'=>$_POST['title'],'author_id'=>$_POST['author_id'],'category_id'=>$_POST['category_id'],'instructions'=>$_POST['instructions'],'token'=>get_option('redigir_token'),'user_id'=>get_option('redigir_user_id')),



          'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )



      );



                                    



      $res = wp_remote_retrieve_body(wp_remote_post('http://redigir.net/api/article_add',$args));



      return $res;  



  }



  



  // Sendback an article



  function redigir_article_sendback($article_id){



      $args = array(



          'timeout' => 3,



          'body' => array ('article_id'=>$article_id,'token'=>get_option('redigir_token'),'user_id'=>get_option('redigir_user_id')),



          'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )



      );



                                    



      $res = wp_remote_retrieve_body(wp_remote_post('http://redigir.net/api/article_sendback',$args));



      return $res;  



  }      







  // Add a new comment



  function redigir_comment_add($article_id){



      $args = array(



          'timeout' => 3,



          'body' => array ('message'=>$_POST['message'],'article_id'=>$article_id,'token'=>get_option('redigir_token'),'user_id'=>get_option('redigir_user_id')),



          'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )



      );                



                                    



      $res = wp_remote_retrieve_body(wp_remote_post('http://redigir.net/api/comment_add',$args));



      return $res;  



  }



  



  // Approve article



  function redigir_article_approve($article_id){



      $args = array(



          'timeout' => 3,



          'body' => array ('article_id'=>$article_id,'token'=>get_option('redigir_token'),'user_id'=>get_option('redigir_user_id')),



          'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )



      );



      



      $a = redigir_get_article($article_id);



      



      $post = array();



      $post['post_title'] = $a['title'];



      $post['post_content'] = $a['title'];



      $post['post_status'] = 'draft';



      $post['post_author'] = 1;        



      wp_insert_post( $post );            



      var_dump(wp_remote_retrieve_body(wp_remote_post('http://redigir.net/api/article_approve',$args)));                             



      //$res = wp_remote_retrieve_body(wp_remote_post('http://redigir.net/api/article_approve',$args));



      return $res;  



  }  



  



  // Display an article



  function redigir_article(){



      $article_id = $_GET['article_id'];



      



      // Run the possible operations



      if ( $_POST['operation'] == 'Recusar' ){



          redigir_article_sendback($article_id);



          $message = 'Artigo recusado, e o autor será notificado.';



      }      



      else if ( $_POST['operation'] == 'Aprovar' ){



          redigir_article_approve($article_id);



          $message = 'Artigo aprovado com sucesso.';



      }



      



      if ( $_POST['action'] == 'comment_add' ){



          if ( redigir_comment_add($article_id) == 'OK' ){



              $message = 'Comentário inserido com sucesso.';



          }



          else {



              $message = 'Não foi possível inserir o comentário.';



          }          



      }        



  



      // Get the article from API 



      $a = redigir_get_article($article_id);      



?>



<div class="wrap">



    <h2><?=$a['title']?></h2>



    <?php if ( isset($message) ){ ?>



        <div class="updated below-h2" id="message"><p><?=$message?></p></div>



    <?php } ?>



    <table class="form-table">



        <tr valign="top">



            <th scope="row"><b>Título</b></th>



            <td><?=$a['title']?></td>



        </tr>    



        <tr valign="top">



            <th scope="row"><b>Conteúdo</b></th>



            <td style="background-color:white;border:1px solid grey"><?=$a['content']?></td>



        </tr>



        <tr valign="top">



            <th scope="row"><b>Categoria</b></th>



            <td><?=$a['category']?></td>



        </tr>                        



        <tr valign="top">



            <th scope="row"><b>Autor</b></th>



            <td><?=$a['author']?></td>



        </tr>



        <tr valign="top">



            <th scope="row"><b>Estado</b></th>



            <td><?=$a['status']?></td>



        </tr>



        <?php if ( $a['status'] == 'Submetido' ){ ?>        



            <tr valign="top">



                <th scope="row"><b>Operações</b></th>



                <td>                    



                   <form method="post"><input type="submit" name="operation" value="Recusar" /><input type="submit" name="operation" value="Aprovar" /></form>



                </td>



            </tr>                                 



        <?php } ?>



    </table>



    <p><h2>Comentários a este artigo</h2></p>    



    <?php



        foreach( $a['comments'] as $c ){



    ?><?=$c['name']?> @ <?=$c['created_at']?><div style="padding:5px;background-color:white;border:1px solid grey"><?=$c['message']?></div><br><?php            



        }



    ?>



    <p><h2>Introduzir comentário</h2></p>



    <p>



        <form method="post">



            <input type="hidden" name="action" value="comment_add" />



            <textarea name="message" cols="80" rows="5"></textarea><br>



            <input type="submit" name="operation" value=" Inserir comentário " />



        </form>



    </p>    



    <p><h3>Resumo das operações disponíveis:</h3></p>



    <p><b>Aprovar</b> - O artigo passa a aprovado na plataforma. É neste momento que os seus fundos são actualizados para reflectir o gasto.</p>



    <p><b>Recusar</b> - O artigo é enviado novamente para o autor a fim de fazer as necessárias alterações.</p>     



</div>



<?php  



  }  



  



  // Main page



  function redigir_main(){



      $version = redigir_get_version();



      if ( $version != REDIGIR_VERSION ){



          $message = 'Existe uma versão mais recente deste plugin, para fazer download do mesmo basta consultar a <a title="Página de Downloads" target="_blank" href="http://wordpress.org/extend/plugins/redigirnet/admin/">página de downloads</a>.';



      }



?>



<div class="wrap">



    <h2>Redigir.net - Geral</h2>    



    <?php if ( isset($message) ){ ?>



        <div class="updated below-h2" id="message"><p><?=$message?></p></div>



    <?php } ?>    



    <h3>Menu</h3>



    » <a title="Artigos requisitados" href="admin.php?page=redigir_pending_articles">Artigos requisitados</a><br>



    » <a title="Fazer requisição" href="admin.php?page=redigir_create_article">Fazer requisição</a><br>



    <h3>Detalhes da conta</h3>



    <p><b>Número de comprador:</b> <?=get_option('redigir_user_id')?></p>



    <p><b>E-mail:</b> <?=get_option('admin_email')?></p>



    <p><b>Fundos:</b> <?=redigir_get_funds()?> EUR</p>    



    <p>



      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">



        <input type="hidden" name="item_number" value="Carregamento de fundos para a plataforma Redigir.net">



        <input type="hidden" name="cmd" value="_xclick">



        <input type="hidden" name="no_note" value="1">



        <input type="hidden" name="business" value="payments@redigir.net">



        <input type="hidden" name="currency_code" value="EUR">



        <input type="hidden" name="notify_url" value="http://redigir.net/api/payment/<?=get_option('redigir_user_id')?>">



        <input type="hidden" name="rm" value="2">



        <input type="hidden" name="lc" value="PT"/>        



        <input type="hidden" name="return" value="<?=get_bloginfo('url').'/wp-admin/admin.php?page=redigir-main'?>">



        <input name="item_name" type="hidden" id="item_name"  size="45" value="Carregamento">        



        <b>Adicionar fundos:</b> Montante: <input name="amount" type="text" id="amount" size="5" maxlength="5">        



        <input type="submit" name="Submit" value="Adicionar fundos">



      </form>    



    </p>



    <h3>Acerca</h3>    



    <p>O <a title="Redigir.net" href="http://redigir.net/">Redigir.net</a> é uma plataforma inovadora que reduz a distância entre a oferta e procura de conteúdo, removendo a necessidade de comunicar manualmente com os autores. Através do Redigir.net pode escolher o melhor autor à sua medida e ao melhor preço.</p>



    <p>Todos os autores são avaliados com base num conjunto de critérios que visam uma maior transparência da qualidade do autor, e se o seu preço é justo. Oferecemos a possibilidade do autor melhorar a qualidade dos seus artigos e assim pedir uma maior recompensação pelo seu esforço.</p>



    <h3>Perguntas Frequentes</h2>



    <p><b>Posso partilhar a minha conta entre vários blogs ?</b></p>



    <p>Sim, no entanto é preciso usar o mesmo e-mail de administração no blog Wordpress.</p>



    <p><b>O que é o número de comprador ?</b></p>



    <p>É um ID único associado à sua conta.</p>



    <h3>Controlo de versões</h3>



    <p>Versão a ser usada: <?=REDIGIR_VERSION?></p>



    <p>Versão a ser usada: <?=$version?></p>    



</div>



<?php



  }



  



  // Main page



  function redigir_create_article(){



      if ( count($_POST) > 0 ){



          $res = redigir_article_add();



          



          if ( $res == 'OK' ){



              $message = 'Artigo criado com sucesso.';



          }



          else {



              $message = 'Não foi possível processar a submissão do seu artigo.'; 



          }



      }  



?>



<div class="wrap">



    <h2>Redigir.net - Fazer uma nova requisição</h2>



    <?php if ( isset($message) ){ ?>



        <div class="updated below-h2" id="message"><p><?=$message?></p></div>



    <?php } ?>    



    <?php if( redigir_get_funds() > 0 ){ ?>



    <p>Nesta página pode criar um artigo novo.</p>



    <form method="post">                



        <table class="form-table">



            <tr valign="top">



                <th scope="row">Título</th>



                <td><input type="text" name="title" size="70" value="" /></td>



            </tr>



            <tr valign="top">



                <th scope="row">Número de palavras</th>



                <td>



                    <input type="text" id="words" name="words" size="4" value="600" />                    



                </td>



            </tr>



            <tr valign="top">



                <th scope="row">Instruções</th>



                <td><textarea cols="65" name="instructions"></textarea></td>



            </tr>



            <tr valign="top">



                <th scope="row">Categoria</th>



                <td>



                  <select name="category_id">



                      <?php



                          $cs = redigir_get_categories();



                          foreach($cs as $c_id=>$c_name){



                      ?>



                          <option value="<?=$c_id?>"><?=$c_name?></option>



                      <?php



                          }



                      ?>



                  </select>



                </td>



            </tr>



            <tr valign="top">



                <th scope="row">Referências</th>



                <td>



                   <input type="text" name="source1" size="100" value="" /><br>



                   <input type="text" name="source2" size="100" value="" /><br>



                   <input type="text" name="source3" size="100" value="" /><br>



                   <input type="text" name="source4" size="100" value="" /><br>



                   <input type="text" name="source5" size="100" value="" />



                </td>



            </tr>            



            <tr valign="top">



                <th scope="row">Autor</th>



                <td>



                      <?php



                          $us = redigir_get_authors();



                          foreach($us as $u){



                      ?>



                          <input onclick="document.getElementById('price').value = (<?=round($u['rate'],2)?>*parseFloat(document.getElementById('words').value))/600;" type="radio" name="author_id" value="<?=$u['id']?>"> <?=$u['name']?><br>



                          <b>Rate:</b> <?=$u['rate']?> EUR / 600 palavras <b>Avaliação média:</b> <?=round($u['avg_rate'],2)?><br><br>



                      <?php



                          }



                      ?>



                </td>



            </tr>



            <tr valign="top">



                <th scope="row">Preço</th>



                <td>



                    <input type="text" id="price" name="price" size="4" value="0" readonly /> EUR                    



                </td>



            </tr>                        



            <tr valign="top">



                <th scope="row"></th>



                <td><input type="submit" value=" Fazer requisição " /></td>



            </tr>                                  



        </table>              



    </form>



    <?php } else { ?>



        <p>A sua conta não tem fundos suficientes para fazer a requisição de novos artigos, adicione fundos à sua conta.</p>



    <?php } ?>



</div>



<?php



  }



  



  // Pending articles



  function redigir_pending_articles(){



?>



<div class="wrap">



    <h2>Redigir.net - Artigos requisitados</h2>    



    <p>



    <?php



        $as = redigir_get_pending_articles();

        

        if ( is_array($as) > 0 ){



    ?>



        <p>Consulte o estado dos seus artigos requisitados.</p>



        <table class="widefat post fixed" cellspacing="0">



            <thead>



                <tr>	



                <th style="" class="manage-column" id="title" scope="col">ID</th>



                <th style="" class="manage-column column-title" id="title" scope="col">Título</th>



                <th style="" class="manage-column column-author" id="author" scope="col">Autor</th>



                <th style="" class="manage-column column-author" id="author" scope="col">Data criação</th>



                <th style="" class="manage-column column-author" id="author" scope="col">Data reserva</th>



                <th style="" class="manage-column column-author" id="author" scope="col">Estado</th>            



                </tr>



            </thead>



    <?php         



            foreach($as as $a){

                ?><tr><td><b>#<?=$a['id']?></b></td><td><a title="<?=$a['title']?>" href="admin.php?page=redigir_article&article_id=<?=$a['id']?>"><?=$a['title']?></a></td><td><?=$a['author']?></td><td><?=$a['created_at']?></td><td><?=$a['picked_at']?></td><td><?=$a['status']?></td></tr><?php



            }



    ?>



        </table>



        <h3>Resumo do estado:</h3>



        <p><b>Submetido</b> - O artigo foi submetido pelo autor, é necessário a sua aprovação. Quando o artigo passa a aprovado é automaticamente criado um post no blog com o conteúdo do artigo requisitado.</p>



        <p><b>Reservado</b> - O artigo está neste momento reservado e a ser escrito pelo autor.</p>



        <p><b>Não reservado</b> - O autor original abandonou o artigo, e está neste momento à espera de um novo autor na plataforma.</p>



    <?php } else { ?>



    Neste momento não existem artigos requisitados associados à sua conta.



    <?php } ?>



    </p>



</div>



<?php



  }      



  



  function redigir_add_menu_items(){



    	add_menu_page('Redigir.net','Redigir.net',10,'redigir_main','redigir_main','/'.REDIGIR_PATH.'img/report.png');      



    	add_submenu_page('redigir_main','Geral','Geral',10,'redigir_main','redigir_main');    	    	



    	add_submenu_page('redigir_main','Artigos requisitados','Artigos requisitados',10,'redigir_pending_articles','redigir_pending_articles');    	



    	add_submenu_page('redigir_main','Fazer requisição','Fazer requisição',10,'redigir_create_article','redigir_create_article');



    	if ( isset($_GET['article_id']) ){



          add_submenu_page('redigir_main','Artigo','Artigo',10,'redigir_article','redigir_article');



      }                      	



	}



?>
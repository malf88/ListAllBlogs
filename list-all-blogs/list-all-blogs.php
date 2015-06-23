<?php
/*
Plugin Name: List All Blogs
Plugin URI:  http://sandbox.maridoedani.com/plugin-listar-todos-os-blogs
Description: Plugin para listar todos os blogs da rede de blogs
Version: 1.0
Author: Marco Aurélio Lima Fernandes
Author URI: https://sandbox.maridoedani.com
License: Marido e Dani V1
*/
add_action('widgets_init', create_function('', 'return register_widget("ListAllBlogs");'));
class ListAllBlogs extends WP_Widget {  
    public function ListAllBlogs(){
        parent::WP_Widget(false, $name = 'List All Blogs');
    }
    /**
    * Exibição final do Widget (já no sidebar)
    *
    * @param array $argumentos Argumentos passados para o widget
    * @param array $instancia Instância do widget
    */
    public function widget($argumentos, $instancia) {
        global $wpdb;
        $args = array(
            'network_id' => 1,
            'public'     => null,
            'archived'   => null,
            'mature'     => null,
            'spam'       => null,
            'deleted'    => null,
            'limit'      => 100,
            'offset'     => 0,
        );
        
        $blog_list = wp_get_sites( $args );
        
        echo $argumentos['before_widget'];
        echo $argumentos['before_title'] . (($instancia['title_widget'])?$instancia['title_widget'] : _e('Lista de blogs')) . $argumentos['after_title'];
        echo '<ul class="'.$instancia['class_widtget'].'">';
        foreach ($blog_list AS $blog) {
            
            if(get_current_blog_id() != $blog['blog_id'] ){
                $blogName = get_blog_details( $blog['blog_id'] );
               
                echo '<li><a href="'.$blogName->siteurl.'" title="'.$blogName->blogname.'">'.$blogName->blogname.'</a></li>';
        
            }
        }
        echo '</ul>';
        echo $argumentos['after_widget'];
    }
    public function update($nova_instancia, $instancia_antiga) {            
        $instancia = array_merge($instancia_antiga, $nova_instancia);
     
        return $instancia;
    }
    public function form($instancia) {  
        $widget['title_widget'] = $instancia['title_widget'];
        $widget['class_widget'] = $instancia['class_widget'];
         ?>
<p><label for="<?php echo $this->get_field_id('title_widget'); ?>"><strong><?php _e('Título'); ?>:</strong></label><br /><input id="<?php echo $this->get_field_id('title_widget'); ?>" name="<?php echo $this->get_field_name('title_widget'); ?>" type="text" value="<?php echo $widget['title_widget'] ?>" /></p>
<p><label for="<?php echo $this->get_field_id('class_widget'); ?>"><strong><?php _e('Classe da lista'); ?>:</strong></label> <br /><input id="<?php echo $this->get_field_id('class_widget'); ?>" name="<?php echo $this->get_field_name('class_widget'); ?>" type="text" value="<?php echo $widget['class_widget'] ?>" /></p>
        <?php   



    }
}
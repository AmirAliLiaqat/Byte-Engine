<?php
  if ( !defined( 'ABSPATH' ) ) {
    exit;
  }

  class Byte_Engine_Image_Maker_Widget extends \Elementor\Widget_Base {
    public function get_name() {
      return 'wp_maker_image';
    }

    public function get_title() {
      return __( 'WP Maker Image', 'wp-maker-image' );
    }

    public function get_icon() {
      return 'eicon-image-rollover';
    }

    public function get_categories() {
      return [ 'basic' ];
    }

    // Your widget's sidebar settings
    protected function _register_controls() {
      $this->start_controls_section(
        'section_image', [
          'label' => __( 'Settings', 'my-domain' ),
        ]
      );

      $this->add_control(
        'image', [
          'label' => __( 'Choose image:', 'my-domain' ),
          'type' => \Elementor\Controls_Manager::MEDIA,
          'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
          ],
        ]
      );

      $this->add_control(
        'video', [
          'label' => __( 'Choose video:', 'my-domain' ),
          'type' => \Elementor\Controls_Manager::MEDIA,
          'media_type' => 'video',
          'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
          ],
        ]
      );

      $this->add_control(
        'show_textarea', [
          'label' => __( 'Add overlay text?', 'my-domain' ),
          'type' => \Elementor\Controls_Manager::SWITCHER,
          'default' => '',
          'label_on' => __( 'Yes', 'my-domain' ),
          'label_off' => __( 'No', 'my-domain' ),
          'return_value' => 'yes',
          'separator' => 'before',
        ]
      );

      $this->add_control(
        'textarea', [
          'label' => __( 'Choose text:', 'my-domain' ),
          'type' => \Elementor\Controls_Manager::TEXTAREA,
          'default' => '',
          'placeholder' => __( 'Enter your text here', 'my-domain' ),
          'condition' => [
          'show_textarea' => 'yes',
          ],
        ]
      );

      $this->end_controls_section();

      $this->start_controls_section(
        'section_size', [
          'label' => __( 'Size & Shape', 'my-domain' ),
        ]
      );

      $this->add_control(
        'width', [
          'label' => __( 'Width (%)', 'my-domain' ),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'range' => [
            'percent' => [
              'min' => 1,
              'max' => 100,
            ],
          ],
          'default' => [
            'size' => 100,
          ],
        ]
      );

      $this->add_control(
        'height', [
          'label' => __( 'Height (px)', 'my-domain' ),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'range' => [
            'px' => [
              'min' => 20,
              'max' => 1500,
            ],
          ],
          'default' => [
            'size' => 360,
          ],
        ]
      );

      $this->add_control(
        'radius', [
          'label' => __( 'Radius (px)', 'my-domain' ),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'range' => [
            'px' => [
              'min' => 0,
              'max' => 750,
            ],
          ],
          'default' => [
            'size' => 25,
          ],
        ]
      );

      $this->end_controls_section();      
    }

    // What your widget displays on the front-end
    protected function render() {
      $settings = $this->get_settings_for_display();

      $image_url = $settings['image']['url'];
      $video_url = $settings['video']['url'];
      $show_textarea = $settings['show_textarea'];
      $textarea = $settings['textarea'];
      $width = $settings['width']['size'] . '%';
      $height = $settings['height']['size'] . 'px';
      $radius = $settings['radius']['size'] . 'px';

      $widget = $this->get_data();
      $unique_id = $widget['id'];

      ?>
      <div id="myDiv<?php echo $unique_id; ?>">
        <img id="myImage<?php echo $unique_id; ?>" src="<?php echo $image_url; ?>">
        <video id="myVideo<?php echo $unique_id; ?>" src="<?php echo $video_url; ?>" style="display: none;" muted loop playsinline></video>
        <div id="myOverlay<?php echo $unique_id; ?>">
        <?php if ( 'yes' === $show_textarea ) : ?>
          <h3><?php echo $textarea; ?></h3>
        <?php endif; ?>
        </div>
      </div>

      <style>
        #myDiv<?php echo $unique_id; ?> {
          height: <?php echo $height; ?>;
          width: <?php echo $width; ?>;
          position: relative;
          border-radius: <?php echo $radius; ?>;
          overflow: hidden;
        }

        #myImage<?php echo $unique_id; ?> {
          width: 100%;
          height: 100%;
          object-fit: cover;
        }

        #myVideo<?php echo $unique_id; ?> {
          width: 100%;
          height: 100%;
          object-fit: cover;
        }

        <?php if ( 'yes' === $show_textarea ) : ?>
        #myOverlay<?php echo $unique_id; ?> {
          position: absolute;
          bottom: 0;
          left: 0;
          right: 0;
          background-color: rgba(0, 0, 0, 0.5);
          color: white;
          padding: 25px;
          display: none;
        }

        #myOverlay<?php echo $unique_id; ?> h3 {
          font-family: Arial, sans-serif;
          font-size: 24px;
          text-align: center;
          color: white;
          margin-bottom: 0;
        }
        <?php endif; ?>
      </style>

      <script>
        document.getElementById("myDiv<?php echo $unique_id; ?>").addEventListener("mouseenter", showVideo);
        document.getElementById("myDiv<?php echo $unique_id; ?>").addEventListener("mouseleave", hideVideo);

        function showVideo() {
          // Get the video element
          var video = document.getElementById("myVideo<?php echo $unique_id; ?>");

          // Get the image element
          var image = document.getElementById("myImage<?php echo $unique_id; ?>");

          // Get the overlay element
          var overlay = document.getElementById("myOverlay<?php echo $unique_id; ?>");

          // Hide the image and show the video and overlay
          image.style.display = "none";
          video.style.display = "block";
          overlay.style.display = "block";

          // Play the video
          video.play();
        }

        function hideVideo() {
          // Get the video element
          var video = document.getElementById("myVideo<?php echo $unique_id; ?>");

          // Get the image element
          var image = document.getElementById("myImage<?php echo $unique_id; ?>");

          // Get the overlay element
          var overlay = document.getElementById("myOverlay<?php echo $unique_id; ?>");

          // Hide the video and overlay, and show the image
          video.style.display = "none";
          overlay.style.display = "none";
          image.style.display = "block";

          // Pause the video on mouse leave, and set its current play time back to the start
          video.pause();
          video.currentTime = 0;
        }
      </script>
      <?php
    }
  }
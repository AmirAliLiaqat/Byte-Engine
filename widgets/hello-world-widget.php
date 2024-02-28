<?php
	if ( !defined( 'ABSPATH' ) ) {
		exit;
	}
	class Byte_Engine_Hello_World_Widget extends \Elementor\Widget_Base {
		public function get_name() {
			return 'hello_world_widget';
		}

		public function get_title() {
			return esc_html__( 'Hello World', 'byte_engine' );
		}

		public function get_icon() {
			return 'eicon-code';
		}

		public function get_categories() {
			return [ 'basic' ];
		}

		public function get_keywords() {
			return [ 'hello', 'world' ];
		}

		protected function register_controls() {
			// Registering section 1
			$this->start_controls_section(
				'section_title',
				[
					'label' => esc_html__( 'Title', 'byte_engine' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'image',
				[
					'type' => \Elementor\Controls_Manager::MEDIA,
					'label' => esc_html__( 'Choose Image', 'byte_engine' ),
					'default' => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					]
				]
			);

			$this->add_control(
				'title',
				[
					'label' => esc_html__( 'Title', 'byte_engine' ),
					'type' => \Elementor\Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'Hello world', 'byte_engine' ),
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Text Color', 'byte_engine' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hello-world' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'size',
				[
					'type' => \Elementor\Controls_Manager::NUMBER,
					'label' => esc_html__( 'Size', 'byte_engine' ),
					'placeholder' => '0',
					'min' => 0,
					'max' => 100,
					'step' => 1,
					'default' => 50,
				]
			);

			$this->add_control(
				'open_lightbox',
				[
					'type' => \Elementor\Controls_Manager::SELECT,
					'label' => esc_html__( 'Lightbox', 'byte_engine' ),
					'options' => [
						'default' => esc_html__( 'Default', 'byte_engine' ),
						'yes' => esc_html__( 'Yes', 'byte_engine' ),
						'no' => esc_html__( 'No', 'byte_engine' ),
					],
					'default' => 'no',
				]
			);

			$this->add_control(
				'alignment',
				[
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'label' => esc_html__( 'Alignment', 'byte_engine' ),
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'byte_engine' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'byte_engine' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'byte_engine' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'default' => 'center',
				]
			);

			$this->add_control(
				'font_size',
				[
					'type' => \Elementor\Controls_Manager::SLIDER,
					'label' => esc_html__( 'Size', 'byte_engine' ),
					'size_units' => [ 'px', 'em', 'rem', 'custom' ],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 200,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 20,
					],
				]
			);

			$this->add_control(
				'popover-toggle',
				[
					'label' => esc_html__( 'Box', 'hello-world' ),
					'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
					'label_off' => esc_html__( 'Default', 'hello-world' ),
					'label_on' => esc_html__( 'Custom', 'hello-world' ),
					'return_value' => 'yes',
				]
			);

			$this->end_controls_section();

			// Registering section 2
			$this->start_controls_section(
				'section_title_style',
				[
					'label' => esc_html__( 'Title', 'byte_engine' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			// responsive controls
			$this->add_responsive_control(
				'space_between',
				[
					'type' => \Elementor\Controls_Manager::SLIDER,
					'label' => esc_html__( 'Spacing', 'hello-world' ),
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'desktop_default' => [
						'size' => 30,
						'unit' => 'px',
					],
					'tablet_default' => [
						'size' => 20,
						'unit' => 'px',
					],
					'mobile_default' => [
						'size' => 10,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .widget-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'title_padding',
				[
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'label' => esc_html__( 'Padding', 'hello-world' ),
					'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
					'selectors' => [
						'{{WRAPPER}} .widget-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'content_align',
				[
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'label' => esc_html__( 'Alignment', 'hello-world' ),
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'hello-world' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'hello-world' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'hello-world' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'devices' => [ 'desktop', 'tablet' ],
					'prefix_class' => 'content-align-%s',
				]
			);

			// grouping controls
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .hello-world',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'selector' => '{{WRAPPER}} .hello-world',
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			?>

			<div class="hello-world">
				<p><?php echo $settings['title']; ?></p>
				<img src="<?php echo $settings['image']; ?>" alt="">
			</div>

			<?php
		}
	}
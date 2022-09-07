var ttm = ttm || {};

(function ( $, _ ) {
	var wp = window.wp;

	ttm = {
		init: function () {
			this.$body = $( 'body' );
			this.$modal = $( '#ttm-settings' );
			this.itemData = {};
			this.templates = {};

			this.frame = wp.media( {
				library: {
					type: 'image'
				}
			} );

			this.initTemplates();
			this.initActions();
		},

		initTemplates: function () {
			_.each( ttmModals, function ( name ) {
				ttm.templates[name] = wp.template( 'megashop-' + name );
			} );
		},

		initActions: function () {
			ttm.$body
				.on( 'click', '.openmenusettings', this.openModal )
				.on( 'click', '.ttm-modal-backdrop, .ttm-modal-close, .ttm-button-cancel', this.closeModal );

			ttm.$modal
				.on( 'click', '.ttm-menu a', this.switchPanel )
				.on( 'click', '.ttm-column-handle', this.resizeMegaColumn )
                                .on( 'change', '.megaColumn', this.setMegaColumn )
                                .on( 'change', '.megaEnable', this.setMegaMenuEnable )
				.on( 'click', '.ttm-button-save', this.saveChanges )
                                .on( 'click', '#insert-my-media', this.open_media_window )                             
                                .on( 'click', '#insert-icon-media', this.open_icon_window );     
                
                                
		},
                 open_media_window: function ( e ) {
			e.preventDefault();
			var thisvar = $( this );
                    var frame;
                    if (frame) {
                        frame.open();
                        return;
                    }
                    frame = wp.media({
                        title: 'upload image',
                        button: {
                            text: 'select'
                        },
                        library: {type: 'image'},
                        multiple: false
                    });
                    frame.on('select', function () {
                        var attachment = frame.state().get('selection').first().toJSON();
                        
                        thisvar.prev().find('.itemContent').val(thisvar.prev().find('.itemContent').val() +'<img src="' + attachment.url + '" alt="" style="max-width:100%; float:left;"/>');
                        
                    });

                    frame.open();
                },
                open_icon_window: function ( e ) {
			e.preventDefault();
			var thisvar = $( this );
                    var frame;
                    if (frame) {
                        frame.open();
                        return;
                    }
                    frame = wp.media({
                        title: 'upload image',
                        button: {
                            text: 'select'
                        },
                        library: {type: 'image'},
                        multiple: false
                    });
                    frame.on('select', function () {
                        var attachment = frame.state().get('selection').first().toJSON();
                        
                        thisvar.parent().find('#ttm-icon-image').val(attachment.url);
                        thisvar.parent().find('#ttm-selected-icon-image').html('<img src="' + attachment.url + '" alt="" style="width:100%; float:left; height:100%"/>');
                        
                    });

                    frame.open();
                },
		openModal: function () {
			ttm.getItemData( this );

			ttm.$modal.show();
			ttm.$body.addClass( 'modal-open' );
			ttm.render();

			return false;
		},

		closeModal: function () {
			ttm.$modal.hide().find( '.ttm-content' ).html( '' );
			ttm.$body.removeClass( 'modal-open' );
			return false;
		},

		switchPanel: function ( e ) {
			e.preventDefault();

			var $el = $( this ),
				panel = $el.data( 'panel' );

			$el.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
			ttm.openmenusettings( panel );
		},

		render: function () {
			// Render menu
			ttm.$modal.find( '.ttm-frame-menu .ttm-menu' ).html( ttm.templates.menus( ttm.itemData ) );

			var $activeMenu = ttm.$modal.find( '.ttm-menu a.active' );

			// Render content
			this.openmenusettings( $activeMenu.data( 'panel' ) );
		},

		openmenusettings: function ( panel ) {
			var $content = ttm.$modal.find( '.ttm-frame-content .ttm-content' ),
				$panel = $content.children( '#ttm-panel-' + panel );

			if ( $panel.length ) {
				$panel.addClass( 'active' ).siblings().removeClass( 'active' );
			} else {
				$content.append( ttm.templates[panel]( ttm.itemData ) );
				$content.children( '#ttm-panel-' + panel ).addClass( 'active' ).siblings().removeClass( 'active' );

				if ( 'mega' == panel ) {
					ttm.initMegaColumns();
				}
				if ( 'background' == panel ) {
					ttm.initBackgroundFields();
				}
				if ( 'icon' == panel ) {
					ttm.initIconFields();
				}
			}

			// Render title
			var title = ttm.$modal.find( '.ttm-frame-menu .ttm-menu a[data-panel=' + panel + ']' ).data( 'title' );
			ttm.$modal.find( '.ttm-frame-title' ).html( ttm.templates.title( {title: title} ) );
		},
                
                setMegaColumn: function (e) {
                    e.preventDefault();
                    var $el = $( e.currentTarget )
                    var colval = this.value;
                    var itm = $el.closest( '.mega-settings' ).parent().find('.ttm-submenu-column');
                   
                            var currentWidth = itm.data( 'width' );
                            
                            var $columns = ttm.$modal.find( '#ttm-panel-mega .ttm-submenu-column' )
                            if ( !$columns.length ) {
                                    return;
                            }
                            // Support maximum 4 columns
                            var defaultWidth = String( parseFloat( 100 / colval ).toFixed( 2 ) ) + '%';
                            
                            if ( colval == 6 ) {
                                    defaultWidth = 16.66 + '%';
                            }
                            _.each( $columns, function ( column ) {
				var $column = $( column ),
					//width = column.dataset.width;                                        
				width = defaultWidth;

				var widthData = ttm.getWidthData( width , colval );

				column.style.width = widthData.width;
				column.dataset.width = widthData.width;
                                itm.data( 'width', width );
                                itm.css('width',width);

				$column.find( '.menu-item-depth-0 .menu-item-width' ).val( width );
				$column.find( '.ttm-column-width-label' ).text( widthData.label );
                                $column.find( '.menu-item-depth-0 .menu-item-menuColumn' ).val( widthData.menuColumn );
                                $column.find( '.menu-item-menuColumn' ).val( widthData.menuColumn );
			} );
                            
			
		},
                setMegaMenuEnable: function (e) {
                    e.preventDefault();
                    var menuenable = this.value;
                    if(menuenable == '1'){
                        ttm.$modal.find('#ttm-mega-content').addClass('active-mega');
                        ttm.$modal.find('#ttm-mega-content').removeClass('disabled');
                    }else if(menuenable == '0'){
                        ttm.$modal.find('#ttm-mega-content').addClass('disabled');
                        ttm.$modal.find('#ttm-mega-content').removeClass('active-mega');
                    }
			
		},
		resizeMegaColumn: function ( e ) {
			e.preventDefault();
                        var colval = ttm.$modal.find('.megaColumn').val();
                        
			var $el = $( e.currentTarget ),
				$column = $el.closest( '.ttm-submenu-column' ),
				currentWidth = $column.data( 'width' ),
				widthData = ttm.getWidthData( currentWidth , colval ),
				nextWidth;

			if ( ! widthData ) {
				return;
			}

			if ( $el.hasClass( 'ttm-resizable-w' ) ) {
				nextWidth = widthData.increase ? widthData.increase : widthData;
			} else {
				nextWidth = widthData.decrease ? widthData.decrease : widthData;
			}

			$column[0].style.width = nextWidth.width;
			$column.data( 'width', nextWidth.width );
			$column.find( '.ttm-column-width-label' ).text( nextWidth.label );
			$column.find( '.menu-item-depth-0 .menu-item-width' ).val( nextWidth.width );                        
                        $column.find( '.menu-item-depth-0 .menu-item-menuColumn' ).val( nextWidth.menuColumn );
                        $column.find( '.menu-item-menuColumn' ).val( nextWidth.menuColumn );
		},

		getWidthData: function( width , colval ) {
                     if(colval == 6){
                         var steps = [                            
                                {width: '16.66%', label: '1/6',menuColumn:'1'},                            
                                {width: '33.33%', label: '2/6',menuColumn:'2'},
                                {width: '50.00%', label: '3/6',menuColumn:'3'},
                                {width: '66.66%', label: '4/6',menuColumn:'4'},
                                {width: '83.33%', label: '5/6',menuColumn:'5'},
                                {width: '100.00%', label: '6/6',menuColumn:'6'}
                                ];
                     }else if(colval == 5){
                         var steps = [                                     
                                {width: '20.00%', label: '1/5',menuColumn:'1'},
                                {width: '40.00%', label: '2/5',menuColumn:'2'},
                                {width: '60.00%', label: '3/5',menuColumn:'3'},
                                {width: '80.00%', label: '4/5',menuColumn:'4'},
                                {width: '100.00%', label: '5/5',menuColumn:'5'}
                                ];
                     }else if(colval == 4){
                         var steps = [                           
				{width: '25.00%', label: '1/4',menuColumn:'1'},
                                {width: '50.00%', label: '2/4',menuColumn:'2'},
                                {width: '75.00%', label: '3/4',menuColumn:'3'},
                                {width: '100.00%', label: '4/4',menuColumn:'4'}
                                ];
                     }else if(colval == 3){
                         var steps = [                       
                                {width: '33.33%', label: '1/3',menuColumn:'1'}, 
				{width: '66.66%', label: '2/3',menuColumn:'2'},                                
                                {width: '100.00%', label: '3/3',menuColumn:'3'}
                                ];
                     }else if(colval == 2){
                         var steps = [    
				{width: '100.00%', label: '1/1',menuColumn:'1'},                             
				{width: '50.00%', label: '1/2',menuColumn:'2'}
                                ];
                     }else{
                         var steps = [                     
                                {width: '100.00%', label: '1/1',menuColumn:'1'}
                                ];
                     }
			var index = _.findIndex( steps, function( data ) {return data.width == width;} );

			if ( index === 'undefined' ) {
				return false;
			}

			var data = {
				index: index,
				width: steps[index].width,
				label: steps[index].label,
                                menuColumn: steps[index].menuColumn
			};

			if ( index > 0 ) {
				data.decrease = {
					index: index - 1,
					width: steps[index - 1].width,
					label: steps[index - 1].label,
                                        menuColumn: steps[index - 1].menuColumn
				};
			}

			if ( index < steps.length - 1 ) {
				data.increase = {
					index: index + 1,
					width: steps[index + 1].width,
					label: steps[index + 1].label,
                                        menuColumn: steps[index + 1].menuColumn
				};
			}

			return data;
		},

		initMegaColumns: function () {
                        
			var $columns = ttm.$modal.find( '#ttm-panel-mega .ttm-submenu-column' ),
				defaultWidth = '25.00%';

			if ( !$columns.length ) {
				return;
			}
                        
                        //$columns.data( 'width' );
                        var colval = ttm.$modal.find('.megaColumn').val();
                        var menuenable = ttm.$modal.find('.megaEnable').val();
                        
                    if(menuenable == '1'){
                        ttm.$modal.find('#ttm-mega-content').addClass('active-mega');
                        ttm.$modal.find('#ttm-mega-content').removeClass('disabled')
                    }else if(menuenable == '0'){
                        ttm.$modal.find('#ttm-mega-content').addClass('disabled');
                        ttm.$modal.find('#ttm-mega-content').removeClass('active-mega');
                    }
			// Support maximum 4 columns
                        defaultWidth = String( parseFloat( 100 / colval ).toFixed( 2 ) ) + '%';
                            
                        if ( colval == 6 ) {
                                defaultWidth = 16.66 + '%';
                        }

			_.each( $columns, function ( column ) {
				var $column = $( column ),
					width = column.dataset.width;                                        
				width = width || defaultWidth;

				var widthData = ttm.getWidthData( width ,colval );

				column.style.width = widthData.width;
				column.dataset.width = widthData.width;
				$( column ).find( '.menu-item-depth-0 .menu-item-width' ).val( width );
				$( column ).find( '.ttm-column-width-label' ).text( widthData.label );
                                $( column ).find( '.menu-item-depth-0 .menu-item-menuColumn' ).val( widthData.menuColumn );
                                $( column ).find( '.menu-item-menuColumn' ).val( widthData.menuColumn );
			} );
		},

		initBackgroundFields: function () {
			ttm.$modal.find( '.background-color-picker' ).wpColorPicker();

			// Background image
			ttm.$modal.on( 'click', '.background-image .upload-button', function ( e ) {
				e.preventDefault();

				var $el = $( this );

				// Remove all attached 'select' event
				ttm.frame.off( 'select' );

				// Update inputs when select image
				ttm.frame.on( 'select', function () {
					// Update input value for single image selection
					var url = ttm.frame.state().get( 'selection' ).first().toJSON().url;

					$el.siblings( '.background-image-preview' ).html( '<img src="' + url + '">' );
					$el.siblings( 'input' ).val( url );
					$el.siblings( '.remove-button' ).removeClass( 'hidden' );
				} );

				ttm.frame.open();
			} ).on( 'click', '.background-image .remove-button', function ( e ) {
				e.preventDefault();

				var $el = $( this );

				$el.siblings( '.background-image-preview' ).html( '' );
				$el.siblings( 'input' ).val( '' );
				$el.addClass( 'hidden' );
			} );

			// Background position
			ttm.$modal.on( 'change', '.background-position select', function () {
				var $el = $( this );

				if ( 'custom' == $el.val() ) {
					$el.next( 'input' ).removeClass( 'hidden' );
				} else {
					$el.next( 'input' ).addClass( 'hidden' );
				}
			} );
		},

		initIconFields: function () {
			var $input = ttm.$modal.find( '#ttm-icon-input' ),
                        $inputimage = ttm.$modal.find( '#ttm-icon-image' ),
				$preview = ttm.$modal.find( '#ttm-selected-icon' ),
                                $iconimage = ttm.$modal.find( '#ttm-selected-icon-image' ),
				$icons = ttm.$modal.find( '.ttm-icon-selector .icons i' );

			ttm.$modal.on( 'click', '.ttm-icon-selector .icons i', function () {
				var $el = $( this ),
					icon = $el.data( 'icon' );

				$el.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );

				$input.val( icon );
				$preview.html( '<i class="' + icon + '"></i>' );
			} );
                        
                        $preview.on( 'click', 'i', function () {
				$( this ).remove();
				$input.val( '' );
			} );
                        
			$iconimage.on( 'click', 'img', function () {
				$( this ).remove();
				$inputimage.val( '' );
			} );

			ttm.$modal.on( 'keyup', '.ttm-icon-search', function () {
				var term = $( this ).val().toUpperCase();

				if ( !term ) {
					$icons.show();
				} else {
					$icons.hide().filter( function () {
						return $( this ).data( 'icon' ).toUpperCase().indexOf( term ) > -1;
					} ).show();
				}
			} );
		},

		getItemData: function ( menuItem ) {
			var $menuItem = $( menuItem ).closest( 'li.menu-item' ),
				$menuData = $menuItem.find( '.mega-data' ),
				children = $menuItem.childMenuItems(),
				megaData = $menuData.data( 'mega' );                                
			megaData.content = $menuData.html();
			ttm.itemData = {
				depth   : $menuItem.menuItemDepth(),
				megaData: megaData,
				data    : $menuItem.getItemData(),
				children: [],
				element : $menuItem.get( 0 )
			};

			if ( !_.isEmpty( children ) ) {
				_.each( children, function ( item ) {
					var $item = $( item ),
						$itemData = $item.find( '.mega-data' ),
						depth = $item.menuItemDepth(),
						megaData = $itemData.data( 'mega' );

					megaData.content = $itemData.html();
                                        
					ttm.itemData.children.push( {
						depth   : depth,
						subDepth: depth - ttm.itemData.depth - 1,
						data    : $item.getItemData(),
						megaData: megaData,
						element : item
					} );
				} );
			}

			console.log( ttm.itemData );
		},

		setItemData: function ( item, data ) {
			var $dataHolder = $( item ).find( '.mega-data' );

			if ( _.has( data, 'content' ) ) {
				$dataHolder.html( data.content );
				//delete data.content;
			}

			$dataHolder.data( 'mega', data );
		},

		getFieldName: function ( name, id ) {
			name = name.split( '.' );
			name = '[' + name.join( '][' ) + ']';

			return 'menu-item-mega[' + id + ']' + name;
		},

		saveChanges: function () {
			var data = ttm.$modal.find( '.ttm-content :input' ).serialize(),
				$spinner = ttm.$modal.find( '.ttm-toolbar .spinner' );

			$spinner.addClass( 'is-active' );
			$.post( ajaxurl, {
				action: 'megashop_save_menu_item_data',
				data  : data
			}, function ( res ) {
				if ( !res.success ) {
					return;
				}

				var data = res.data['menu-item-mega'];

				// Update parent menu item
				if ( _.has( data, ttm.itemData.data['menu-item-db-id'] ) ) {
					ttm.setItemData( ttm.itemData.element, data[ttm.itemData.data['menu-item-db-id']] );
				}

				_.each( ttm.itemData.children, function ( menuItem ) {
					if ( !_.has( data, menuItem.data['menu-item-db-id'] ) ) {
						return;
					}

					ttm.setItemData( menuItem.element, data[menuItem.data['menu-item-db-id']] );
				} );

				$spinner.removeClass( 'is-active' );
				ttm.closeModal();
			} );
		}
	};

	$( function () {
		ttm.init();
	} );
})( jQuery, _ );

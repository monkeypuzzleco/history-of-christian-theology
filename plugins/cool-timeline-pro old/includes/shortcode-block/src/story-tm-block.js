/**
 * Block dependencies
 */
import React, { useEffect } from 'react';
import CtlIcon from './icons';
import CtlLayoutType from './layout-type'
import PreviewImage from './images/timeline.png'

/**
 * Internal block libraries
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const baseURL=ctlUrl.CTP_PLUGIN_URL;
const wpBaseURL=ctlUrl.baseURL;
const LayoutImgPath=baseURL+'/includes/gutenberg-block/layout-images';
const { apiFetch } = wp;
const {
	RichText,
	InspectorControls,
	BlockControls,
} = wp.editor;
const { Fragment } = wp.element
const { 
	PanelBody,
	PanelRow,
	TextareaControl,
	TextControl,
	Dashicon,
	Toolbar,
	ButtonGroup,
	Button,
	SelectControl,
	Tooltip,
	RangeControl,
	TabPanel,
	Card,
	CardBody,
	FormTokenField,
	ExternalLink
} = wp.components;


var ctlCategories = [];
var ctlfilterCategories=[];
//http://localhost/wp-test/wp-json/cooltimeline/v1/categories
const allPosts = wp.apiFetch({path:'/cooltimeline/v1/categories'}).then(posts => {
	ctlCategories.push({label: "Select a Category", value:''});
	if(posts.categories!==undefined){
		for (var key in posts.categories) {
		ctlCategories.push({label:posts.categories[key], value:key});
		ctlfilterCategories.push(posts.categories[key]);
	}
	return ctlCategories;
	}
});
/**
 * Register block

 */
export default registerBlockType( 'cool-timleine/shortcode-block', {
		// Block Title
		title: __( 'Story Timeline Shortcode' ),
		// Block Description
		description: __( 'Cool Timeline Shortcode Generator.' ),
		// Block Category
		category: 'common',
		// Block Icon
		icon:CtlIcon,
		// Block Keywords
		keywords: [
			__( 'cool timeline' ),
			__( 'timeline shortcode' ),
			__( 'cool timeline block' )
		],
	attributes: {
		layout: {
			type: 'string',
			default: 'default'
		},
		skin: {
			type: 'string',
			default: 'default'
		},
		postperpage: {
            type: 'string',
            default:10
        },
		storyDateVisibility:{
			type: 'string',
			default: 'show'
		},
		dateformat: {
			type: 'string',
			default:  'F j'
		},
		customDateFormat:{
			type: 'string',
			default: ''
		},
		icons: {
			type: 'string',
			default:  'dot'
		},
		animation: {
			type: 'string',
			default:  'none'
		},
		designs:{
			type: 'string',
			default:  'design-1'
		},
		storycontent:{
			type: 'string',
			default:  'short'
		},
		category:{
			type: 'string',
			default:''
		},
		based:{
			type: 'string',
			default:  'default'
		},
		compactelepos:{
			type: 'string',
			default:  'main-date'
		},
		pagination:{
			type: 'string',
			default:  'default'
		},
		filters:{
			type: 'string',
			default:  'no'
		},
		hrYearLabel:{
			type: 'string',
			default:  'show'
		},
		hrNavigation:{
			type: 'string',
			default:  'hide'
		},
		hrNavigationPosition:{
			type: 'string',
			default:  ''
		},
		filtercategories:{
			type: 'string',
			default:  ''
		},
		items:{
			type: 'string',
			default:  ''
		},
		lineFilling:{
			type: 'string',
			default: 'false'
		},
		readMoreVisibility:{
			type: 'string',
			default: 'show'
		},
		contentLength:{
			type: 'string',
			default: 50
		},
		autoplay:{
			type: 'string',
			default:  'false'
		},
		autoplayspeed:{
			type: 'string',
			default:3000
		},
		starton:{
			type: 'string',
			default: 0
		},
		order:{
			type: 'string',
			default:'DESC'
		},
		isPreview:{
			type: 'boolean',
			default: false
		},
		filterCategoriesOption:{
			type: 'array',
			default: []
		},
		filterSettingUsed:{
			type:'boolean',
			default:false
		},
		settingsMigration:{
			type:'string',
			default: 'true'
		},
		timelineTitle:{
			type:'string',
			default:''
		}
		
	},
	// Defining the edit interface
	edit: props => {
		const skinOptions = [
            { value: 'default', label: __( 'Default' ) },
			{ value: 'dark', label: __( 'Dark' ) },
			{ value: 'light', label: __( 'Light' ) }
		];

		const DfromatOptions = [
		 {value:"F j",label:"January 1 (F j)"},
		 {value:"F j Y",label:"January 1 2019 (F j Y)"},
		 {value:"Y-m-d",label:"2019-01-01 (Y-m-d)"},
		 {value:"m/d/Y",label:"01/01/2019 (m/d/Y)"},
		 {value:"d/m/Y",label:"01/01/2019 (d/m/Y)"},
		 {value:"F j Y g:i A",label:"January 1 2019 11:10 AM (F j Y g:i A)"},
		 {value:"Y",label:" 2019(Y)"},
		 {label:"Custom",value:"custom"}
		  ];
		
		const layoutOptions = [
            { value: 'default', label: __( 'Vertical' ) },
			{ value: 'horizontal', label: __( 'Horizontal' ) },
			{ value: 'one-side', label: __( 'One Side Layout' ) },
			{ value: 'compact', label: __( 'Compact Layout' ) }
		];
			const animationOptions=[
				{label:"None",value:"none"},
				{label:"fade",value:"fade"},
			{label:"zoom-in",value:"zoom-in"},
			{label:"flip-right",value:"flip-right"},
			{label:"zoom-out",value:"zoom-out"},
			{label:"fade-up",value:"fade-up"},
			{label:"fade-down",value:"fade-down"},
			{label:"fade-left",value:"fade-left"},
			{label:"fade-right",value:"fade-right"},
			{label:"fade-up-right",value:"fade-up-right"},
			{label:"fade-up-left",value:"fade-up-left"},
			{label:"fade-down-right",value:"fade-down-right"},
			{label:"fade-down-left",value:"fade-down-left"},
			{label:"flip-up",value:"flip-up"},
			{label:"flip-down",value:"flip-down"},
			{label:"flip-left",value:"flip-left"},
			{label:"slide-up",value:"slide-up"},
			{label:"slide-left",value:"slide-left"},
			{label:"slide-right",value:"slide-right"},
			{label:"zoom-in-up",value:"zoom-in-up"},
			{label:"zoom-in-down",value:"zoom-in-down"},
			{label:"slide-down",value:"slide-down"},
			{label:"zoom-in-left",value:"zoom-in-left"},
			{label:"zoom-in-right",value:"zoom-in-right"},
			{label:"zoom-out-up",value:"zoom-out-up"},
			{label:"zoom-out-down",value:"zoom-out-down"},
			{label:"zoom-out-left",value:"zoom-out-left"},
			{label:"zoom-out-right",value:"zoom-out-right"},
			
		];
			const timelineDesigns=[
			{label:"Default",value:"design-1"},
			{label:"Flat Design",value:"design-2"},
			{label:"Classic Design",value:"design-3"},
			{label:"Elegant Design",value:"design-4"},
			{label:"Clean Design",value:"design-5"},
			{label:"Modern Design",value:"design-6"},
			{label:"Minimal Design",value:"design-7"}
			];
			
			const compact_ele_pos=[
			{label:"On top date/label below title",value:"main-date"},
			{label:"On top title below date/label",value:"main-title"}
			];

			const timeline_based_on=[{label:"Default(Date Based)",value:"default"},
			{label:"Custom Order",value:"custom"}
			];

			const paginationOptions='horizontal' === props.attributes.layout ?
			[{label: "Off",value:"off"},
			{label:"Ajax Load More",value:"ajax_load_more"}] :
			[{label: "Off",value:"off"},
			{label: "default",value:"default"},
			{label:"Ajax Load More",value:"ajax_load_more"}]
			;

			const hrNavigationPositionOption='horizontal'=== props.attributes.layout ?
			[{label:"Left",value:"left"},
			{label:"Right",value:"right"},
			{label:"Center",value:"center"}
			] :
			[{label:"Left",value:"left"},
			{label:"Right",value:"right"},
			{label:"Bottom",value:"bottom"}
			];

			const categoriesFilterUpdate=(e)=>{
				props.setAttributes( { filterCategoriesOption: e } )
				
				const allCategoryList=ctlCategories.map(values=>{
					if(e.includes(values.label)){
						return values.value;
					}
				});
				
				const categoriesFilter=allCategoryList.filter(values=>{
					return values !== undefined;
				});
				
				props.setAttributes({filtercategories: categoriesFilter.toString()});
			};

			const hrNavPostion='horizontal'===props.attributes.layout ? 'left' : 'right';
			
			if(props.attributes.filterSettingUsed == false && props.attributes.category != '' && props.attributes.filtercategories == '' && props.attributes.filters == 'yes'){
				const selectedCat=ctlCategories.filter((value)=>{
					return value['value'] == props.attributes.category;
				});
				
				props.setAttributes({filterCategoriesOption: [selectedCat[0]['label']]});
				props.setAttributes({filtercategories: props.attributes.category});
				props.setAttributes({filterSettingUsed: true});
			}

			undefined === props.attributes.settingsMigration || 'true' === props.attributes.settingsMigration && props.setAttributes({ settingsMigration: 'false' });

			const general_settings=
			<PanelBody title={ __( 'Timeline General Settings' ) } >
					<SelectControl
					label={ __( 'Select Layouts' ) }
					options={ layoutOptions }
					value={ props.attributes.layout }
					onChange={ ( value ) =>props.setAttributes( { layout: value } ) }
					/>
					<SelectControl
                    label={ __( 'Select Designs' ) }
                    options={ timelineDesigns }
                    value={ props.attributes.designs }
					onChange={ ( value ) =>props.setAttributes( { designs: value } ) }
					/>
					<SelectControl
                    label={ __( 'Select Skin' ) }
                    options={ skinOptions }
                    value={ props.attributes.skin }
					onChange={ ( value ) =>props.setAttributes( { skin: value } ) }
                    />
					<SelectControl
                    label={ __( 'Categories' ) }
                    options={ ctlCategories }
                    value={ props.attributes.category }
					onChange={ ( value ) =>props.setAttributes( { category: value } ) }
					/>
					<p>Create Category Specific Timeline (By Default - All Categories)</p>
					<SelectControl
					label={ __( 'Timeline Based On' ) }
					options={ timeline_based_on }
					value={ props.attributes.based }
					onChange={ ( value ) =>props.setAttributes( { based: value } ) }
					/>	
					<p>Show either date or custom label/text along with timeline stories.</p>
					<div className="ctl_shortcode-button-group_label">{__("Stories Description?")}</div>
					<ButtonGroup className="ctl_shortcode-button-group">
						<Button onClick={(e) => {props.setAttributes({storycontent: 'short'})}} className={props.attributes.storycontent == 'short' ? 'active': ''} isSmall={true}>Short</Button>
						<Button onClick={(e) => {props.setAttributes({storycontent: 'full'})}} className={props.attributes.storycontent == 'full' ? 'active': ''} isSmall={true}>Full</Button>
					</ButtonGroup>
					<RangeControl
						label="Stories Per Page"
						value={ parseInt(props.attributes.postperpage) }
						onChange={ ( value ) => props.setAttributes( { postperpage: value.toString() } ) }
						min={ 1 }
						max={ 50 }
						step={ 1 }
					/>	
					<p>{props.attributes.layout!="horizontal" && 'You Can Show Pagination After These Posts In Vertical Timeline.'}</p>
					{ props.attributes.layout=="horizontal" &&  
					<Fragment>
					<RangeControl
						label="Slide To Show?"
						value={ props.attributes.items != '' ? parseInt(props.attributes.items) : 0 }
						onChange={ ( value ) => value==0?props.setAttributes( { items: '' } ):props.setAttributes( { items: value.toString() } ) }
						min={ 0 }
						max={ 10 }
						step={ 1 }
					/>
					</Fragment>
					}
				</PanelBody>;
			const advanced_settings=
				<PanelBody title={ __( 'Timeline Advanced Settings' ) } >
					<div className="ctl_shortcode-button-group_label">{__("Stories Order?")}</div>
					<ButtonGroup className="ctl_shortcode-button-group">
						<Button onClick={(e) => {props.setAttributes({order: 'ASC'})}} className={props.attributes.order == 'ASC' ? 'active': ''} isSmall={true}>ASC</Button>
						<Button onClick={(e) => {props.setAttributes({order: 'DESC'})}} className={props.attributes.order == 'DESC' ? 'active': ''} isSmall={true}>DESC</Button>
					</ButtonGroup>
					<p>For Ex :- {props.attributes.order == 'ASC' ? 'ASC(1900-2017)': 'DESC(2017-1900)'}</p>
					<div className="ctl_shortcode-button-group_label">{__("Stories Date?")}</div>
					<ButtonGroup className="ctl_shortcode-button-group">
						<Button onClick={(e) => {props.setAttributes({storyDateVisibility: 'show'})}} className={props.attributes.storyDateVisibility == 'show' ? 'active': ''} isSmall={true}>Show</Button>
						<Button onClick={(e) => {props.setAttributes({storyDateVisibility: 'hide'})}} className={props.attributes.storyDateVisibility == 'hide' ? 'active': ''} isSmall={true}>Hide</Button>
					</ButtonGroup>
					{'show'===props.attributes.storyDateVisibility && 	
					<>				
						<SelectControl
						label={ __( 'Date Formats' ) }
						description={ __( 'yes/no' ) }
						options={ DfromatOptions }
						value={ props.attributes.dateformat }
						onChange={ ( value ) =>props.setAttributes( { dateformat: value } ) }
						/>
						{'custom'===props.attributes.dateformat &&
						<>	
						<TextControl
							label={ __( 'Custom Date Format' ) }
							value={ props.attributes.customDateFormat }
							onChange={ ( value ) =>props.setAttributes( { customDateFormat: value } ) }
						/>	
						<p>Stories date formats e.g D,M,Y <ExternalLink href="https://www.php.net/manual/en/function.date.php">Click here to view more</ExternalLink></p>
						</>
						}
					</>
					}
					<div className="ctl_shortcode-button-group_label">{__("Display Icons (By default Is Dot)")}</div>
					<ButtonGroup className="ctl_shortcode-button-group">
						<Button onClick={(e) => {props.setAttributes({icons: 'icon'})}} className={props.attributes.icons == 'icon' ? 'active': ''} isSmall={true}>Icons</Button>
						<Button onClick={(e) => {props.setAttributes({icons: 'dot'})}} className={props.attributes.icons == 'dot' ? 'active': ''} isSmall={true}>Dot</Button>
						<Button onClick={(e) => {props.setAttributes({icons: 'none'})}} className={props.attributes.icons == 'none' ? 'active': ''} isSmall={true}>None</Button>
					</ButtonGroup>	
					<SelectControl
					label={ __( 'Pagination Settings' ) }
					options={ paginationOptions }
					value={ props.attributes.pagination }
					onChange={ ( value ) =>props.setAttributes( { pagination: value } ) }
					/>
					<Fragment>
						<div className="ctl_shortcode-button-group_label">{__("Show Category Filters")}</div>
						<ButtonGroup className="ctl_shortcode-button-group">
							<Button onClick={(e) => {props.setAttributes({filters: 'yes'})}} className={props.attributes.filters == 'yes' ? 'active': ''} isSmall={true}>Yes</Button>
							<Button onClick={(e) => {props.setAttributes({filters: 'no'})}} className={props.attributes.filters == 'no' ? 'active': ''} isSmall={true}>No</Button>
						</ButtonGroup>
					</Fragment>
					{props.attributes.filters == 'yes' &&
						<FormTokenField
							label={__('Select filter category')}
							value={ props.attributes.filterCategoriesOption }
							suggestions={  ctlfilterCategories }
							onChange={ ( value ) =>{categoriesFilterUpdate(value)} }
							placeholder={'All'}
							__experimentalExpandOnFocus = {true}
							__experimentalShowHowTo ={false}
						/>
					}
					{("compact" !== props.attributes.layout && 'custom' !== props.attributes.based) &&
						<Fragment>
						<div className="ctl_shortcode-button-group_label">{__("Year Label Setting")}</div>
						<ButtonGroup className="ctl_shortcode-button-group">
						<Button onClick={(e) => {props.setAttributes({hrYearLabel: 'show'})}} className={props.attributes.hrYearLabel == 'show' ? 'active': ''} isSmall={true}>Show</Button>
						<Button onClick={(e) => {props.setAttributes({hrYearLabel: 'hide'})}} className={props.attributes.hrYearLabel == 'hide' ? 'active': ''} isSmall={true}>Hide</Button>
						</ButtonGroup>
						</Fragment>
					}
					{((props.attributes.hrYearLabel == "show" || "compact" === props.attributes.layout) && 'custom' !== props.attributes.based) &&
					<Fragment>
					<div className="ctl_shortcode-button-group_label">{__("Year Navigation Setting")}</div>
					<ButtonGroup className="ctl_shortcode-button-group">
					<Button onClick={(e) => {props.setAttributes({hrNavigation: 'show'})}} className={props.attributes.hrNavigation == 'show' ? 'active': ''} isSmall={true}>Show</Button>
					<Button onClick={(e) => {props.setAttributes({hrNavigation: 'hide'})}} className={props.attributes.hrNavigation == 'hide' ? 'active': ''} isSmall={true}>Hide</Button>
					</ButtonGroup>
					</Fragment>
					}
					{((props.attributes.hrYearLabel == "show" || "compact" === props.attributes.layout) && props.attributes.hrNavigation == "show" && 'custom' !== props.attributes.based) &&
					<SelectControl
					label={ __( 'Year Navigation Position' ) }
					options={ hrNavigationPositionOption }
					value={ props.attributes.hrNavigationPosition === '' ? hrNavPostion : props.attributes.hrNavigationPosition }
					onChange={ ( value ) =>props.setAttributes( { hrNavigationPosition: value } ) }
					/>
					}
					<div className="ctl_shortcode-button-group_label">{__("Line Filling Settings?")}</div>
					<ButtonGroup className="ctl_shortcode-button-group">
					<Button onClick={(e) => {props.setAttributes({lineFilling: 'true'})}} className={props.attributes.lineFilling == 'true' ? 'active': ''} isSmall={true}>True</Button>
					<Button onClick={(e) => {props.setAttributes({lineFilling: 'false'})}} className={props.attributes.lineFilling == 'false' ? 'active': ''} isSmall={true}>False</Button>
					</ButtonGroup>
					<div className="ctl_shortcode-button-group_label">{__("Display read more?")}</div>
					<ButtonGroup className="ctl_shortcode-button-group">
					<Button onClick={(e) => {props.setAttributes({readMoreVisibility: 'show'})}} className={props.attributes.readMoreVisibility == 'show' ? 'active': ''} isSmall={true}>Show</Button>
					<Button onClick={(e) => {props.setAttributes({readMoreVisibility: 'hide'})}} className={props.attributes.readMoreVisibility == 'hide' ? 'active': ''} isSmall={true}>Hide</Button>
					</ButtonGroup> 					
					<TextControl
						label={ __( 'Content Length' ) }
						value={ props.attributes.contentLength }
						onChange={ ( value ) =>props.setAttributes( { contentLength: value } ) }
					/>
					{props.attributes.layout == "horizontal" &&
						<Fragment>
						<div className="ctl_shortcode-button-group_label">{__("Autoplay Settings?")}</div>
						<ButtonGroup className="ctl_shortcode-button-group">
						<Button onClick={(e) => {props.setAttributes({autoplay: 'true'})}} className={props.attributes.autoplay == 'true' ? 'active': ''} isSmall={true}>True</Button>
						<Button onClick={(e) => {props.setAttributes({autoplay: 'false'})}} className={props.attributes.autoplay == 'false' ? 'active': ''} isSmall={true}>False</Button>
						</ButtonGroup>
						<TextControl
						label={ __('Slideshow Speed ?' ) }
						value={ props.attributes.autoplayspeed }
						onChange={ ( value ) =>props.setAttributes( { autoplayspeed: value } ) }
						/>	
						<TextControl
						label={ __( 'Timeline Starting from Story e.g(2)' ) }
						value={ props.attributes.starton }
						onChange={ ( value ) =>props.setAttributes( { starton: value } ) }
						/>	
						</Fragment>
					}
					{ props.attributes.layout!="horizontal" &&
					<>
						<Fragment>
							<SelectControl
							label={ __( 'Animation' ) }
							description={ __( 'yes/no' ) }
							options={ animationOptions }
							value={ props.attributes.animation }
							onChange={ ( value ) =>props.setAttributes( { animation: value } ) }
							/>
							{ props.attributes.layout=="compact" &&  
							<SelectControl
							label={ __( 'Compact Layout Date&Title positon' ) }
							description={ __( 'yes/no' ) }
							options={ compact_ele_pos }
							value={ props.attributes.compactelepos }
							onChange={ ( value ) =>props.setAttributes( { compactelepos: value } ) }
							/>
							}
						</Fragment>
						<TextControl
						label={ __( 'Timeline Title' ) }
						value={ props.attributes.timelineTitle }
						onChange={ ( value ) =>props.setAttributes( { timelineTitle: value } ) }
						/>
					</>
					}
				</PanelBody>;
		return [
			!! props.isSelected && (
				<InspectorControls key="inspector">
					<TabPanel
					className="ctl_shortcode-tab-settings"
					activeClass="active-tab"
					tabs={ [
						{
							name: 'general_settings',
							title: 'General',
							className: 'ctl-settings_tab-one',
							content: general_settings
						},
						{
							name: 'advanced_settings',
							title: 'Advanced',
							className: 'ctl-settings_tab-two',
							content: advanced_settings
						},
					] }
					>
						{ ( tab ) => <Card>{tab.content}</Card> }
					</TabPanel>
				</InspectorControls>
			),
			props.attributes.isPreview ? <img src={PreviewImage}></img> :
			<div className={ props.className }>			
				<CtlLayoutType type="storytm"   LayoutImgPath={LayoutImgPath} attributes={props.attributes} />
				<div className="ctl-block-shortcode">
				{ props.attributes.layout=="horizontal" &&  
				<div>
					[cool-timeline 
					category="{props.attributes.category}" 
					layout="{props.attributes.layout}" 
					designs="{props.attributes.designs}" 
					skin="{props.attributes.skin}" 
					show-posts="{props.attributes.postperpage}" 
					story-date="{props.attributes.storyDateVisibility}"
					date-format="{props.attributes.dateformat}" 
					custom-date-format="{props.attributes.customDateFormat}"
					icons="{props.attributes.icons}" 
					story-content="{props.attributes.storycontent}" 
					based="{props.attributes.based}" 
					items="{props.attributes.items}" 
					pagination="{props.attributes.pagination}"
					year-label="{props.attributes.hrYearLabel}" 
					year-navigation="{props.attributes.hrNavigation}"
					navigation-position="{props.attributes.hrNavigationPosition}"  
					filters="{props.attributes.filters}" 
					filter-categories="{props.attributes.filtercategories}"
					start-on="{props.attributes.starton}" 
					line-filling="{props.attributes.lineFilling}"
					read-more="{props.attributes.readMoreVisibility}"
					content-length="{props.attributes.contentLength}"
					autoplay="{props.attributes.autoplay}" 
					autoplay-speed="{props.attributes.autoplayspeed}" 
					order="{props.attributes.order}"]
				</div>
				}

			{ props.attributes.layout!="horizontal" &&  
				<div>
				[cool-timeline category="{props.attributes.category}" 
				layout="{props.attributes.layout}" 
				designs="{props.attributes.designs}" 
				skin="{props.attributes.skin}"
				show-posts="{props.attributes.postperpage}"
				story-date="{props.attributes.storyDateVisibility}"
				date-format="{props.attributes.dateformat}" 
				custom-date-format="{props.attributes.customDateFormat}"
				icons="{props.attributes.icons}" 
				animation="{props.attributes.animation}" 
				story-content="{props.attributes.storycontent}" 
				based="{props.attributes.based}" 
				compact-ele-pos="{props.attributes.compactelepos}" 
				pagination="{props.attributes.pagination}"
				year-label="{props.attributes.hrYearLabel}" 
				year-navigation="{props.attributes.hrNavigation}"
				navigation-position="{props.attributes.hrNavigationPosition}"
				filters="{props.attributes.filters}" 
				filter-categories="{props.attributes.filtercategories}"
				line-filling="{props.attributes.lineFilling}"
				read-more="{props.attributes.readMoreVisibility}"
				content-length="{props.attributes.contentLength}"
				order="{props.attributes.order}"
				timeline-title="{props.attributes.timelineTitle}"]
				</div>
			}
				</div>
			</div>
		];
	},
	// Defining the front-end interface
	save() {
		// Rendering in PHP
		return null;
	},
	example: {
		attributes: {
			isPreview: true,
		},
	},
});

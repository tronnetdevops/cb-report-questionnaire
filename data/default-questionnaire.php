<?php
$defaultData = array(
	'config' => array(
		'options' => array(
			'highlight' => '#48D1CC',
			'color' => '#CC0000'
		),
		'buttons' => array(
			'shape' => 'rectangle',
			'normal' => array(
				'background' => '#FFFFFF',
				'color' => '#000000'
			),
			'selected' => array(
				'background' => '#48D1CC',
				'color' => '#000000'
			)
		)
	),
	'results' => array(
		array(
			'text' => 'Address',
			'id' => 0
		),
		array(
			'text' => 'Birthday',
			'id' => 1
		),
		array(
			'text' => 'Credit or debit card',
			'id' => 2
		),
		array(
			'text' => 'Email',
			'id' => 3
		),
		array(
			'text' => 'Employment history',
			'id' => 4
		),
		array(
			'text' => 'Financial history',
			'id' => 5
		),
		array(
			'text' => 'Fingerprints',
			'id' => 6
		),
		array(
			'text' => 'Health history',
			'id' => 7
		),
		array(
			'text' => 'Password (encrypted)',
			'id' => 8
		),
		array(
			'text' => 'Phone number',
			'id' => 9
		),
		array(
			'text' => 'Social Security Number',
			'id' => 10
		)
	),
	
	'questions' => array(
		array(
			'id' => 0,
			'name' => 'Job Application',
			'question' => 'Have you applied for a job with or worked for the federal government since 2000?',
			'type' => 'radio',
			'options' => array(
				array(
					'id' => 0,
					'name' => 'Yes',
					'description' => '',
					'results' => array(0, 4, 5, 6, 10)
				),
				array(
					'id' => 1,
					'name' => 'No',
					'description' => '',
					'results' => array()
				)
			)
		),
		
		array(
			'id' => 1,
			'name' => 'Account Websites',
			'question' => 'Have you signed up for an account with these websites?',
			'type' => 'multiselect',
			'options' => array(
				array(
					'id' => 0,
					'name' => 'Adobe',
					'description' => 'Before Oct. 2013',
					'results' => array(2,8)
				),
				array(
					'id' => 1,
					'name' => 'AOL',
					'description' => 'Before April 2014',
					'results' => array(0,3,4,8)
				),
				array(
					'id' => 2,
					'name' => 'eBay',
					'description' => 'Before May 2014',
					'results' => array(0,1,3,8,9)
				),
				array(
					'id' => 3,
					'name' => 'livingsocial',
					'description' => 'Before April 2014',
					'results' => array(1,3,8)
				),
				array(
					'id' => 4,
					'name' => 'slack',
					'description' => 'Before Feb 2015',
					'results' => array(3,8,9)
				),
				array(
					'id' => 5,
					'name' => 'snapchat',
					'description' => 'Before Jan 2014',
					'results' => array(9)
				),
				array(
					'id' => 6,
					'name' => 'twitch',
					'description' => 'Before March 2015',
					'results' => array(0,1,3,8,9)
				),
				array(
					'id' => 7,
					'name' => 'twitter',
					'description' => 'Before Feb 2013',
					'results' => array(3,8)
				)
			)
		),
		
		array(
			'id' => 2,
			'name' => 'Insurance Providers',
			'question' => 'Did you have health insurance from these providers?',
			'type' => 'multiselect',
			'options' => array(
				array(
					'id' => 0,
					'name' => 'Anthem',
					'description' => 'Before Jan. 2015',
					'results' => array(0,1,3,4,7,10)
				),
				array(
					'id' => 1,
					'name' => 'CareFirst',
					'description' => 'Before June 2014',
					'results' => array(1,3)
				),
				array(
					'id' => 2,
					'name' => 'CHS',
					'description' => 'Before July 2014',
					'results' => array(0,1,4,9,10)
				),
				array(
					'id' => 3,
					'name' => 'Premera',
					'description' => 'Before Jan. 2014',
					'results' => array(0,1,3,7,9,10)
				)
			)
		),
		
		array(
			'id' => 3,
			'name' => 'Credit at Retailers',
			'question' => 'Did you use a credit or debit card at these retailers?',
			'type' => 'multiselect',
			'options' => array(
				array(
					'id' => 0,
					'name' => 'Albertsons',
					'description' => 'June 2014 - July 2014',
					'results' => array(2)
				),
				array(
					'id' => 1,
					'name' => 'Dairy Queen',
					'description' => 'Aug. 2014 - Sept. 2014',
					'results' => array(2)
				),
				array(
					'id' => 2,
					'name' => 'Goodwill',
					'description' => 'Feb. 2013 - Aug. 2014',
					'results' => array(2)
				),
				array(
					'id' => 3,
					'name' => 'Home Depot',
					'description' => 'April 2014 - Sept. 2014',
					'results' => array(2,3)
				),
				array(
					'id' => 4,
					'name' => 'Kmart',
					'description' => 'Sept. 2014 - Oct. 2014',
					'results' => array(2)
				),
				array(
					'id' => 5,
					'name' => 'Michaels Stores',
					'description' => 'May 2013 - Jan. 2014',
					'results' => array(2)
				),
				array(
					'id' => 6,
					'name' => 'Neiman Marcus',
					'description' => 'July 2013 - Oct. 2013',
					'results' => array(2)
				),
				array(
					'id' => 7,
					'name' => 'P.F. Chang\'s',
					'description' => 'Feb. 2014 - June 2014',
					'results' => array(2)
				),
				array(
					'id' => 8,
					'name' => 'Sally Beauty Supply',
					'description' => 'March 2014 - April 2015',
					'results' => array(2)
				),
				array(
					'id' => 9,
					'name' => 'Staples',
					'description' => 'July 2014 - Sept. 2014',
					'results' => array(2)
				),
				array(
					'id' => 10,
					'name' => 'Supervalu',
					'description' => 'June 2014 - July 2014',
					'results' => array(2)
				),
				array(
					'id' => 11,
					'name' => 'Target',
					'description' => 'Nov. 2013 - Dec. 2013',
					'results' => array(0,2,3,9)
				),
				array(
					'id' => 12,
					'name' => 'United Parcel Service',
					'description' => 'Jan. 2014 - Aug. 2014',
					'results' => array(0,2,3)
				)
			)
		)
	)
);
?>
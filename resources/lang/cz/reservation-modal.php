<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 27/06/2017
 * Time: 10:44
 */

return [
	'title'          => 'Vytvoření rezervace',
	'save'           => 'Vytvořit',
	'renew'          => 'Prodloužit',
	'renew-to'       => 'Prodloužit do',
	'renew-title'    => 'Prodloužení rezervace',
	'note'           => 'Poznámka',
	'cancel'         => 'Zrušit',
    'update'         => 'Zmenit',
	'delete'         => 'Smazat',
	'visitors_count' => 'Počet účastníků',
	'required_order' => 'Vytvořením rezervace souhlasíš s provozním řádem.',
	'console'        => 'Konzole',
	'from_date'      => 'Datum od',
	'from_time'      => 'Čas od',
	'to_date'        => 'Datum do',
	'to_time'        => 'Čas do',
    'duration'       => 'Trvani',
    'hours'          => 'hodin',

    'failed'         => [
		'title'    => 'To přece nemůžeš.',
		'parallel' => [
			'text' => 'Nemůžeš být na dvou místech najednou.',
		],
		'exist'    => [
			'text' => 'Rezervace v tomto čase již existuje.',
		],
		'closed'   => [
			'text' => "Tato místnost je zavřená.",
		],
		'too_long' => [
			'text' => 'Rezervace překračuje ' . config('calendar.max-duration') . ' hodín',
		],
	],
];

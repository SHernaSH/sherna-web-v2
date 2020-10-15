<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 27/06/2017
 * Time: 10:44
 */

return [
    'title'          => 'Create reservation',
    'save'           => 'Create',
    'renew'          => 'Renew',
    'renew-to'       => 'Renew to',
    'renew-title'    => 'Renew reservation',
    'note'           => 'Note',
    'cancel'         => 'Cancel',
    'update'         => 'Update',
    'delete'         => 'Delete',
    'visitors_count' => 'Visitors count',
	'required_order' => 'By creating a reservation, you agree with the operating order.',
    'console'        => 'Console',
    'from_date'      => 'Date from',
    'from_time'      => 'Time from',
    'to_date'        => 'Date to',
    'to_time'        => 'Time to',
    'duration'       => 'Duration',
    'hours'          => 'Hours',
	'failed'         => [
		'title'    => 'You can not do that.',
		'parallel' => [
			'text' => 'You can not be in two places at once.',
		],
		'exist'    => [
			'text' => 'Reservation at this time already exists.',
		],
		'closed'   => [
			'text' => "This room is closed.",
		],
		'too_long' => [
			'text' => 'Reservation exceed ' . config('calendar.max-duration') . ' hours.',
		],
	],
];

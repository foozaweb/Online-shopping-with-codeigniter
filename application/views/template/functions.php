<?php
function shortNumber($num)
{
    $units = ['', 'K', 'M', 'B', 'T'];
    for ($i = 0; $num >= 1000; $i++) {
        $num /= 1000;
    }
    return round($num, 1) . $units[$i];
}


function viewRating($p)
{
    if ($p === null) {
        echo
        '<li class="list-inline-item"><i class="fa fa-star-o"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>';
    }
    if ($p === '1') {
        echo
        '<li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>';
    }
    if ($p === '2') {
        echo
        '<li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>';
    }
    if ($p === '3') {
        echo
        '<li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>';
    }
    if ($p === '4') {
        echo
        '<li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star-o"></i></li>';
    }
    if ($p === '5') {
        echo
        '<li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star"></i></li>
        <li class="list-inline-item"><i class="fa fa-star"></i></li>';
    }
}

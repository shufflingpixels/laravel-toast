<?php 
use ShufflingPixels\Toast\Facades\Toast;

$messages = Toast::getMessages();
?>

@if (!$messages->empty())
<div>
    @foreach($messages as $message)
    <x-toast::message :$message />
    @endforeach
</div>
@endif

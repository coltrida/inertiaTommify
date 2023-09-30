<x-mail::message>
# Introduction

Congratulation!
You bought <b>{{$album['name']}}</b> album

<!--<x-mail::button :url="''">
Button Text
</x-mail::button>-->

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

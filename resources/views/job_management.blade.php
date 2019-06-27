@extends('layouts.app')

@section('content')
<v-container>
    <h5 class="headline">Job Management</h5>
    <v-layout row wrap>
        <v-flex xs12 class="mt-2">
            <job-management auth_id="{{ Auth::id() }}" url="https://google.com/"></job-management>
        </v-flex>
    </v-layout>
</v-container>
@endsection
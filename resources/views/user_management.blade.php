@extends('layouts.app')

@section('content')
<v-container>
    <h5 class="headline">User Management</h5>
    <v-layout row wrap>
        <v-flex xs12>
            <v-layout align-start justify-end row fill-height>
                {{-- <v-btn color="green white--text" class="mx-3">Tambah Sales</v-btn> --}}
                <tambah-sales></tambah-sales>
            </v-layout>
        </v-flex>
        <v-flex xs12 class="mt-2">
            <list-sales url_list_sales="{{ route('list_sales') }}"></list-sales>
        </v-flex>
    </v-layout>
</v-container>
@endsection
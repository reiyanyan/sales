@extends('layouts.app')

@section('content')
<v-container>
    <v-card class="mx-auto" color="#26c6da" dark max-width="400">
        <v-card-title>
            <v-icon large left>favorite</v-icon>
            <span class="title font-weight-light">Twitter</span>
        </v-card-title>
        <v-card-text class="headline font-weight-bold">
            Don't Forget To Rest!
        </v-card-text>
        <v-card-actions>
            <v-list-tile class="grow">
                <v-list-tile-avatar color="grey darken-3">
                    <v-img class="elevation-6" src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"></v-img>
                </v-list-tile-avatar>
                <v-list-tile-content>
                    <v-list-tile-title>Yan</v-list-tile-title>
                </v-list-tile-content>
                <v-layout align-center justify-end>
                    <v-icon class="mr-1">mdi-heart</v-icon>
                    <span class="subheading mr-2">256</span>
                    <span class="mr-1">·</span>
                    <v-icon class="mr-1">mdi-share-variant</v-icon>
                    <span class="subheading">45</span>
                </v-layout>
            </v-list-tile>
        </v-card-actions>
    </v-card>
</v-container>
@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <!-- CDN de Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="flex justify-center">
            <div class="max-w-4xl mx-auto">
                <div class="flex justify-between items-center p-4">
                    <div class="flex items-center">
                        <img src="https://xtrak.goteysoft.com/assets/images/logo.jpg" alt="" class=" object-contain" height="200" width="200">
                    </div>
                    <span class="ml-4 font-semibold">CONFIDENTIEL</span>
                    <div class="flex flex-col ml-4">
                        <div><h6><span class="font-semibold">Réf    : </span><span class="badge bg-gray-100 text-gray-600">{{ $candidate->cre_ref ?? '---' }}</span></h6></div>
                        <div><h6><span class="font-semibold">Auteur : </span><span class="badge bg-gray-100 text-gray-600">{{ $candidate->auteur->trigramme ?? '' }}</span></h6></div>
                        <div><h6><span class="font-semibold">Date   : </span><span class="badge bg-gray-100 text-gray-600">{{ $candidate->cre_created_at ? \Carbon\Carbon::parse($candidate->cre_created_at)->format('d-m-Y') : '--' }}</span></h6></div>
                    </div>
                </div>
                <div class="p-4">
                    <div>
                        <p class="font-semibold">COMPTE RENDU D'ENTRETIEN DE
                            {{ $candidate->civ->name ?? '---' }}. <span
                                class="badge bg-gray-100 text-gray-600">{{ $candidate->first_name ?? '---' }}
                                {{ $candidate->last_name ?? '---' }}</span>
                        </p>
                    </div>
                    <div class="mt-2">
                        <p class="font-semibold">POSTE : <span
                                class="badge bg-gray-100 text-gray-600">{{ $candidate->position->name ?? '---'}}</span>
                        </p>
                    </div>
                </div>
                <div class="p-4">
                    <ol class="list-decimal ml-4">
                        @forelse ($cres as $cre)
                            <li class="mt-4">
                                <p class="font-semibold">{{ $cre->question }} :</p>
                                <p class="bg-gray-100 text-gray-600 text-sm mt-2">{{ $cre->response }}</p>
                            </li>
                        @empty
                            <div class="alert alert-warning" role="alert">
                                Aucun compte rendu d'entretien n'est disponible pour le moment.
                            </div>
                        @endforelse
                    </ol>
                </div>
                
                <div class="flex justify-center mt-5">
                    <span>-----+-----+-----+-----</span>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>

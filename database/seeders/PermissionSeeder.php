<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // 'Menu accès BaseCDT',
            'Menu connexion',
            'Menu activité',
            'Importer des candidats',
            'Ajouter un candidat',
            "Menu etats",
            "Menu saisie",
            "Menu Détails",
            'Menu paramètres',
            'Menu utilisateur',
            'Liste des utilisateurs',
            'Gestion des rôles',
            'Gestion des permissions',
            'Menu paramètre BaseCDT',
            'Gestion des sociétes',
            'Gestion des Métier2',
            'Gestion des Métier1',
            'Gestion des Métier3',
            'Gestion des disponibilites',
            'Gestion des civilites',
            'Gestion des statuts',
            'Gestion des etats',
            "Menu capture / gestion",
            "nextStep",
            "nsDate",
            "CST+ Vue"
        ];
        foreach ($permissions as $key => $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}

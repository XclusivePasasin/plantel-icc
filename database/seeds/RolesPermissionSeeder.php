<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #CL-> Analista de Calidad -> Calidad -> Inspector de Calidad 
        #SCL-> Supervisor de calidad  
        
        $role_cip 	= Role::create(['name' => 'CleanInPlace']); // ID 1 
        $role_materia 	= Role::create(['name' => 'MateriaPrima']); //  ID:2        
        $role_mezcla 	= Role::create(['name' => 'Mezcla']); //ID: 3
        $role_produccion 	= Role::create(['name' => 'Produccion']); //ID 4 
        $role_analisis_calidad 	= Role::create(['name' => 'Calidad']); //ID: 5
        $role_sup_calidad 	= Role::create(['name' => 'SupCalidad']);//Supervisor de Calidad ID: 6         

        $role_bodega 	= Role::create(['name' => 'Bodega']);//Bodega ID: 7         
        $role_admin 	= Role::create(['name' => 'Admin']);//Administrador ID: 8    
        $role_supprod 	= Role::create(['name' => 'SupProduccion']);//Supervisor de produccion ID: 9    
        

        $permission = Permission::create([
			'name' => 'cap-cip',
			'description' => 'Capacidad especificamente para rol CIP'
		]);

        $permission = Permission::create([
			'name' => 'cap-materiaprima',
			'description' => 'Capacidad destinada solo para rol materia prima'
		]);
        $permission = Permission::create([
			'name' => 'cap-supcalidad',
			'description' => 'Capacidad destinada especificamente para rol supervisor de calidad'
		]);
        $permission = Permission::create([
			'name' => 'cap-mezcla',
			'description' => 'Capacidad destinada especificamente para rol mezcla'
		]);
        $permission = Permission::create([
			'name' => 'cap-produccion',
			'description' => 'Capacidad destinada especificamente para rol produccion'
		]);
        $permission = Permission::create([
			'name' => 'cap-calidad',
			'description' => 'Capacidad destinada especificamente para rol analisis de calidad'
		]);
        $permission = Permission::create([
			'name' => 'cap-bodega',
			'description' => 'Capacidad destinada especificamente para rol analisis de calidad'
		]);  

        $permission = Permission::create([
			'name' => 'cap-administrador',
			'description' => 'Capacidad destinada especificamente para rol analisis de calidad'
		]);          
        
        $permission = Permission::create([
			'name' => 'cap-supprod',
			'description' => 'Capacidad destinada especificamente para rol Supervisor de produccion'
		]);             
        


		$permission = Permission::create([
			'name' => 'cargar-ordermix',
			'description' => 'Apartado para cargar un orden desde API o local'
		]);

		$permission = Permission::create([
			'name' => 'approved-ordermix',
			'description' => 'Capacidad de aprovar una orden de produccion, mezcla'
		]);      
        
		$permission = Permission::create([
			'name' => 'times-ordermix',
			'description' => 'Capacidad de marcar tiempos de inicio y fin para orden de produccion, mezcla'
		]);         

        $permission = Permission::create([
			'name' => 'registro-analisis-agua',
			'description' => 'Capacidad de registrar, modificar hoja de granel'
		]); 

		$permission = Permission::create([
			'name' => 'registro-granel',
			'description' => 'Capacidad de registrar, modificar hoja de granel'
		]);         

        
       
        //For CleanInPlace  role 
        $list_permission1 = [
            'cap-cip',
        ];

        //For Materia Prima role 
        $list_permission2 = [
            'cap-materiaprima',
            'cargar-ordermix'
        ];

        //For mezcla role 
        $list_permission3 = [
            'cap-mezcla',
            'registro-analisis-agua',
            'times-ordermix'
        ];  

        //For produccion role 
        $list_permission4 = [
            'cap-produccion',
            'registro-granel'
        ];         

        //For Analista de  Calidad role CL
        $list_permission5 = [
            'cap-calidad'
        ]; 

        //For Sup. Calidad role SCL
        $list_permission6 = [
            'cap-supcalidad',
            'approved-ordermix'
        ];  
        
        //For Bodega role
        $list_permission7 = [
            'cap-bodega'
        ];
        
        //For administrator role 
        $list_permission8 = [
            'cap-administrador'
        ];   
        
        //For sup produccion  role 
        $list_permission9 = [
            'cap-supprod'
        ];         


        

        $role_cip->syncPermissions($list_permission1);
        $role_materia->syncPermissions($list_permission2);
        $role_mezcla->syncPermissions($list_permission3);
        $role_produccion->syncPermissions($list_permission4);
        $role_analisis_calidad->syncPermissions($list_permission5);
        $role_sup_calidad->syncPermissions($list_permission6);
        $role_bodega->syncPermissions($list_permission7);
        $role_admin->syncPermissions($list_permission8);
        $role_supprod->syncPermissions($list_permission9);
        
        #init Comment before prod deploy 
        $cip_user = User::create([
            'name' => 'Javier Bonilla',
            'email' => 'cip@unilever.es',
            'password' => Hash::make('secret1234')
        ]);

        $materia_user = User::create([
            'name' => 'Marvin Cabrera',
            'email' => 'materiaprima@unilever.es',
            'password' => Hash::make('secret1234')
        ]);

        $mezcla_user = User::create([
            'name' => 'Carlos Agustin',
            'email' => 'mezcla@unilever.es',
            'password' => Hash::make('secret1234')
        ]);  

        $produccion_user = User::create([
            'name' => 'Jessica Murcia',
            'email' => 'produccion@unilever.es',
            'password' => Hash::make('secret1234')
        ]);  

        $analista_calidad_user = User::create([
            'name' => 'Angelica Rosalva',
            'email' => 'analisis.calidad@unilever.es',
            'password' => Hash::make('secret1234')
        ]);

        $sup_calidad_user = User::create([
            'name' => 'Jorge Aguilar',
            'email' => 'sup.calidad@unilever.es',
            'password' => Hash::make('secret1234')
        ]);

        $bodega_user = User::create([
            'name' => 'Boris Argueta',
            'email' => 'bodega.empaque@unilever.es',
            'password' => Hash::make('secret1234')
        ]);

        $supprod_user = User::create([
            'name' => 'Saul Mendoza',
            'email' => 'supervisor.produccion@unilever.es',
            'password' => Hash::make('secret1234')
        ]);        

        #End Comment before prod deploy 
        

        $admin_user = User::create([
            'name' => 'Mario Nerio',
            'email' => 'admin@unilever.es',
            'password' => Hash::make('Zy@ZNkiz5Br')
        ]);        
  
        
        #init Comment before prod deploy 
        $cip_user->assignRole('CleanInPlace');
        $materia_user->assignRole('MateriaPrima');
        $mezcla_user->assignRole('Mezcla');
        $produccion_user->assignRole('Produccion');
        $analista_calidad_user->assignRole('Calidad');
        $sup_calidad_user->assignRole('SupCalidad');
        $bodega_user->assignRole('Bodega');
        $supprod_user->assignRole('SupProduccion');
        #End Comment before prod deploy 

        $admin_user->assignRole('Admin');
        
    }
}

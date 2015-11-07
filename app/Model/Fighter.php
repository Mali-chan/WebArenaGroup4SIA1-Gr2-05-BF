<?php

App::uses('AppModel', 'Model');

class Fighter extends AppModel {

    public $displayField = 'name';

    public $belongsTo = array(

        'Player' => array(

            'className' => 'Player',

            'foreignKey' => 'player_id',

        ),

   );
    
         function doMove($fighterId, $direction)
    {
       //récupérer la position et fixer l'id de travail
        $datas = $this->read(null, $fighterId);

       //falre la modif
        if ($direction == 'north')
            $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] + 1);
        elseif ($direction == 'south')
            $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] - 1);
        elseif ($direction == 'east')
            $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] + 1);
        elseif ($direction == 'west')
            $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] - 1);
        else
            return false;

       //sauver la modif
        $this->save();
        return true;
    }
    
    public function doAttack($fighterId,$attack){
 
       
        // on récupère les informations sur le personnage de l'utilisateur
        $dataAttack = $this->findById($fighterId);
                        // récuperer les coordonnées de l'attaquant
                $coordonne_defenseur_x = $dataAttack['Fighter']['coordinate_x'];
                $coordonne_defenseur_y = $dataAttack['Fighter']['coordinate_y'];
 
 
                if($attack == 'attack1') $this->set($coordonne_defenseur_y, $coordonne_defenseur_y + 1);
                if($attack == 'attack2') $this->set($coordonne_defenseur_y, $coordonne_defenseur_y - 1);
                if($attack == 'attack3') $this->set($coordonne_defenseur_x, $coordonne_defenseur_x + 1);
                if($attack == 'attack4') $this->set($coordonne_defenseur_x, $coordonne_defenseur_x - 1);
               
                $dataDefenseur = $this->findByCoordinate_xAndCoordinate_y($coordonne_defenseur_x,$coordonne_defenseur_y);
               
                if(isset($dataDefenseur))
                                {      
                                        pr($dataDefenseur);
                                                                       
                                        $this->set('current_health', $dataDefenseur['Fighter']['current_health'] - $dataAttack['Fighter']['skill_strength']);
                                                                        }
                $this->save();
                return true;
        }

}
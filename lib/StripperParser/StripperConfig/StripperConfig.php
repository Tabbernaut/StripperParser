<?php
/**
 * @package StripperParser
 */

interface StripperConfigInterface
{
    public function propertyExists($property);

    public function validatePropertyValue($property, $value);


}

class StripperConfig implements StripperConfigInterface
{
    public $warnOnEmptyValue = true;

    protected $_config = array(

        // what property types are allowed (any for unlisted)
        'classname' => array(
            '*' => array(
                'origin',
                'angles',
            ),
        ),
        
        // what value validation to apply per property; null for any
        //      any property not listed here will be considered 'unknown'
        //      todo: this list needs cleaning up!
        'property' => array(
            // common
            'origin' => 'vector',
            'angles' => 'vector',
            'solid' => 'int',
            //'solidity' => 'int',            // is this even correct?
            'rendermode' => 'int',
            'rendercolor' => 'color',      // more restricted actually...
            'glowcolor' => 'color',
            'model' => 'path',
            'spawnflags' => 'int',
            'classname' => 'alpha',
            'targetname' => null,
            'parentname' => null,
            'hammerid' => 'int',
            // less common
            'count' => 'int',
            'ammo' => 'int',
            'startdisabled' => 'int',
            'damagefilter' => null,
            'damagetype' => 'int',
            'health' => 'int',
            'radius' => 'float',
            'message' => null,
            'disableshadows' => 'int',
            'scale' => 'float',
            'speed' => 'float',
            'texture' => null,
            'skin' => null,
            'body' => null,
            'spawnpos' => 'int',
            'glowstate' => 'int',
            // even less common
            'initialvalue' => null,
            'initialstate' => 'int',
            'blocktype' => 'int',
            'mins' => 'vector',
            'maxs' => 'vector',
            'boxmins' => 'vector',
            'boxmaxs' => 'vector',
            'physdamagescale' => 'float',
            'nodamageforces' => 'int',
            'performancemode' => 'int',
            'refiretime' => 'float',
            'negated' => null,                          // appears to allow text string
            'breakabletype' => 'int',
            'spawn_without_director' => 'int',
            'scriptfile' => null,
            'population' => null,
            'offer_tank' => 'int',
            'weapon_selection' => null,
            'versustravelcompletion' => 'float',
            'viewangles' => 'vector',
            'hint_caption' => null,
            'max' => 'float',
            'melee_weapon' => null,
            'filtername' => null,
            'use_time' => 'float',
            'startspeed' => 'float',
            'damage' => 'float',
            'hideweapons' => 'int',
            'disablereceiveshadows' => 'int',
            // sound stuff
            'volstart' => 'float',
            'spinup' => 'float',
            'spindown' => 'float',
            'cspinup' => 'float',
            'fadeinsecs' => 'float',
            'fadeoutsecs' => 'float',
            'lfmodpitch' => 'float',
            'lfmodvol' => 'float',
            'lforate' => null,
            'lfotype' => null,
            'pitch' => 'float',
            'pitchstart' => 'float',
            'preset' => 'float',
            'mingpulevel' => 'float',
            'mincpulevel' => 'float',
            'maxgpulevel' => 'float',
            'maxcpulevel' => 'float',
            // item spawning
            'item1' => null, 'item2' => null, 'item3' => null, 'item4' => null, 'item5' => null, 'item6' => null,
            'item7' => null, 'item8' => null, 'item9' => null, 'item10' => null, 'item11' => null, 'item12' => null,
            'item13' => null, 'item14' => null, 'item15' => null, 'item16' => null, 'item17' => null, 'item18' => null,
            // events
            'ontrue' => null,
            'ontrigger' => null,
            'onpressed' => null,
            'onhealthchanged' => null,
            'ontimer' => null,
            'ontimeup' => null,
            'oncoop' => null,
            'onscavenge' => null,
            'onversus' => null,
            'onversuspostio' => null,
            'onsurvival' => null,
            'onmapspawn' => null,
            'oncaralarmstart' => null,
            'oncaralarmend' => null,
            'oncaralarmchirpstart' => null,
            'oncaralarmchirpend' => null,
            'outanger' => null,
            'onopen' => null,
            'onbreak' => null,
            'usestart' => null,
            'onreachedtop' => null,
            'onstarttouch' => null,
            'onendtouch' => null,
            'onentireteamstarttouch' => null,
            'onentireteamendtouch' => null,
            'onhitmax' => null,
            'onpass' => null,
            'onequalto' => null,
            'onhitmin' => null,
            'case01' => null, 'case02' => null, 'case03' => null, 'case04' => null, 'case05' => null, 'case06' => null,
            'case07' => null, 'case08' => null, 'case09' => null, 'case10' => null, 'case11' => null, 'case12' => null,
            'case13' => null, 'case14' => null, 'case15' => null, 'case16' => null,
            'oncase01' => null, 'oncase02' => null, 'oncase03' => null, 'oncase04' => null, 'oncase05' => null,
            'oncase06' => null, 'oncase07' => null, 'oncase08' => null, 'oncase09' => null, 'oncase10' => null,
            'oncase11' => null, 'oncase12' => null, 'oncase13' => null, 'oncase14' => null, 'oncase15' => null,
            'oncase16' => null,
            'template01' => null, 'template02' => null, 'template03' => null, 'template04' => null,
            'template05' => null, 'template06' => null, 'template07' => null, 'template08' => null,
            'template09' => null, 'template10' => null, 'template11' => null, 'template12' => null,
            'template13' => null, 'template14' => null, 'template15' => null, 'template16' => null,
            'fireuser1' => null, 'fireuser2' => null, 'fireuser3' => null, 'fireuser4' => null,
            'onuser1' => null, 'onuser2' => null, 'onuser3' => null, 'onuser4' => null,
            // my goodness, does anyone use these at all?
            'userandomtime' => 'int',
            'upperrandombound' => 'float',
            'lowerrandombound' => 'float',
            'type' => null,
            'gamemode' => 'alpha',
            'shadowcastdist' => 'float',
            'renderfx' => 'int',
            'renderamt' => 'int',
            'pressuredelay' => 'float',
            'minhealthdmg' => 'float',
            'massscale' => 'float',
            'intertiascale' => 'float',
            'forcetoenablemotion' => 'float',
            'damagetoenablemotion' => 'float',
            'fadescale' => 'float',
            'fademindist' => 'float',
            'fademaxdist' => 'float',
            'exploderadius' => 'float',
            'explodedamage' => 'float',
            // generated from dumps:
            '_ambient' => 'color_rgba',
            '_ambienthdr' => 'color_rgba',
            '_ambientscalehdr' => 'float',
            '_castentityshadow' => 'int',
            '_cone' => 'int',
            '_constant_attn' => 'int',
            '_distance' => 'int',
            '_exponent' => 'int',
            '_fifty_percent_distance' => 'int',
            '_hardfalloff' => 'float',
            '_inner_cone' => 'float',
            '_light' => 'color_rgba',
            '_lighthdr' => 'color_rgba',
            '_lightscalehdr' => 'float',
            '_linear_attn' => 'int',
            '_ontrigger' => null,
            '_quadratic_attn' => 'int',
            '_shadoworiginoffset' => 'vector',
            '_zero_percent_distance' => 'int',
            'acceleration' => 'float',
            'adrenalinedensity' => 'float',
            'ajarangles' => 'vector',
            'allowghost' => 'int',
            'allowincap' => 'int',
            'alternateticksfix' => 'int',
            'ammodensity' => 'float',
            'amplitude' => 'int',
            'axis' => 'vector_double',
            'barbed' => 'int',
            'blockdamage' => 'int',
            'bottom' => 'vector',
            'breakable' => 'int',
            'busyactor' => 'int',
            'chainsawdensity' => 'float',
            'clip_3d_skybox_near_to_world_far' => 'int',
            'collide' => 'int',
            'color' => 'color',
            'colorcorrectionname' => null,
            'cpoint1' => null,
            'cpoint1_parent' => 'int',
            'cpoint2' => null,
            'cpoint2_parent' => 'int',
            'cpoint3' => null,
            'cpoint3_parent' => 'int',
            'cpoint4' => null,
            'cpoint4_parent' => 'int',
            'cpoint5' => null,
            'cpoint5_parent' => 'int',
            'cpoint6' => null,
            'cpoint6_parent' => 'int',
            'cpoint7' => null,
            'cpoint7_parent' => 'int',
            'cpoint8' => null,
            'cpoint9' => null,
            'damagecap' => 'int',
            'damagedelay' => 'int',
            'damagemodel' => 'int',
            'damageradius' => 'float',
            'dangling' => 'int',
            'defaultanim' => null,
            'defibrillatordensity' => 'float',
            'detailmaterial' => null,
            'detailvbsp' => 'path',
            'disableallshadows' => 'int',
            'disablex360' => 'int',
            'distance' => 'float',
            'dmg' => 'int',
            'duration' => 'float',
            'effect_name' => null,
            'enableshadowsfromlocallights' => 'int',
            'entireteam' => 'int',
            'event_name' => null,
            'exclusive' => 'int',
            'explodemagnitude' => 'int',
            'explosion' => 'int',
            'fadedist' => 'int',
            'fadeinduration' => 'float',
            'fadeoutduration' => 'float',
            'fadestartdist' => 'float',
            'fadetime' => 'float',
            'fadetoblackstrength' => 'int',
            'farz' => 'int',
            'fieldofview' => 'float',
            'filename' => 'path',
            'filterteam' => 'int',
            'finaleitemclustercount' => 'int',
            'fogblend' => 'int',
            'fogcolor' => 'color',
            'fogcolor2' => 'color',
            'fogdir' => 'vector',
            'fogenable' => 'int',
            'fogend' => 'float',
            'foglerptime' => 'float',
            'fogmaxdensity' => 'float',
            'fogname' => null,
            'fogstart' => 'float',
            'forceclosed' => 'int',
            'forceview' => 'int',
            'fov' => 'float',
            'fov_rate' => 'float',
            'framerate' => 'float',
            'frequency' => 'float',
            'gascandensity' => 'float',
            'gibdir' => 'vector',
            'glowproxysize' => 'float',
            'glowrange' => 'int',
            'grainstrength' => 'float',
            'hardware' => 'int',
            'hdrcolorscale' => 'float',
            'heightfogdensity' => 'float',
            'heightfogmaxdensity' => 'float',
            'heightfogstart' => 'float',
            'holdtime' => 'float',
            'inertiascale' => 'float',
            'inputfilter' => 'int',
            'invert_exclusion' => 'int',
            'itemclusterrange' => 'int',
            'landmark' => null,
            'lfomodpitch' => 'int',
            'lfomodvol' => 'int',
            'lightingorigin' => null,
            'lip' => 'int',
            'localcontrastedgestrength' => 'float',
            'localcontraststrength' => 'float',
            'locked_sentence' => 'int',
            'locked_sound' => 'int',
            'looktime' => 'float',
            'map' => null,
            'mapversion' => 'int',
            'material' => null,
            'maxangerrange' => 'int',
            'maxanimtime' => 'int',
            'maxdxlevel' => 'int',
            'maxfalloff' => 'int',
            'maxpropscreenwidth' => 'int',
            'maxspeed' => 'int',
            'maxweight' => 'float',
            'meleeweapondensity' => 'float',
            'min' => 'int',
            'minangerrange' => 'int',
            'minanimtime' => 'int',
            'mindxlevel' => 'int',
            'minfalloff' => 'float',
            'minspeed' => 'int',
            'molotovdensity' => 'float',
            'movedir' => 'vector',
            'movedistance' => 'int',
            'movespeed' => 'int',
            'musicpostfix' => null,
            'nextkey' => null,
            'nodmgforce' => 'int',
            'noise' => 'int',
            'onawakened' => null,
            'onendtouchall' => null,
            'onentityspawned' => null,
            'ongameplaystart' => null,
            'onnottouching' => null,
            'onplayerdeath' => 'int',
            'onreachedbottom' => null,
            'ontrigger1' => null,
            'onuselocked' => null,
            'opendir' => 'int',
            'order' => 'int',
            'orientationtype' => 'int',
            'overlaycolor' => 'color',
            'overlaymaterial' => null,
            'overlaysize' => 'int',
            'oxygentankdensity' => 'float',
            'painpilldensity' => 'float',
            'pipebombdensity' => 'float',
            'pistoldensity' => 'float',
            'portalnumber' => 'int',
            'portalversion' => 'int',
            'positioninterpolator' => 'int',
            'postprocessname' => null,
            'preciptype' => 'int',
            'precise' => 'int',
            'propanetankdensity' => 'float',
            'propdata' => 'int',
            'pushdir' => 'vector',
            'randomanimation' => 'int',
            'range' => 'int',
            'render_in_front' => 'int',
            'rescueeyepos' => 'vector',
            'returndelay' => 'int',
            'ropematerial' => 'path',
            'scenefile' => 'path',
            'setbodygroup' => 'int',
            'size' => 'int',
            'skyname' => null,
            'slack' => 'int',
            'solidbsp' => 'int',
            'solidity' => 'int',
            'soundlockedoverride' => null,
            'sounds' => 'int',
            'soundscape' => null,
            'sourceentityname' => null,
            'spawnobject' => 'int',
            'start_active' => 'int',
            'startopen' => 'int',
            'startposition' => 'int',
            'startsound' => null,
            'startvalue' => 'float',
            'stopsound' => null,
            'style' => 'int',
            'subdiv' => 'float',
            'sunspreadangle' => 'float',
            'survivorintrosequence' => null,
            'survivorname' => null,
            'target' => null,
            'teamtoblock' => 'int',
            'texturescale' => 'float',
            'thinkalways' => 'int',
            'timeofday' => 'int',
            'timeout' => 'int',
            'top' => 'vector',
            'topvignettestrength' => 'float',
            'translucencylimit' => 'float',
            'triggeronstarttouch' => 'int',
            'unlocked_sentence' => 'int',
            'unlocked_sound' => 'int',
            'updatechildren' => 'int',
            'upgradepackdensity' => 'float',
            'use_angles' => 'int',
            'usewind' => 'int',
            'vignetteblurstrength' => 'float',
            'vignetteend' => 'float',
            'vignettestart' => 'float',
            'vomitjardensity' => 'float',
            'vrad_brush_cast_shadows' => 'int',
            'wait' => 'float',
            'width' => 'float',
            'world_maxs' => 'vector',
            'world_mins' => 'vector',
            'ammopackdensity' => 'float',
            'clip_3d_skybox_near_to_world_far_offset' => 'float',
            'contextsubject' => null,
            'cpoint10' => null,
            'cpoint11' => null,
            'entitytemplate' => null,
            'fanfriction' => 'int',
            'fireballsprite' => null,
            'glow' => null,
            'group00' => null,
            'group01' => null,
            'healthcount' => 'int',
            'ignoredebris' => 'int',
            'imagnitude' => 'int',
            'inner_radius' => 'float',
            'laser_sight' => 'int',
            'loopmovesound' => 'int',
            'magnitude' => 'int',
            'maxrange' => 'int',
            'onfalse' => null,
            'onhitbytank' => null,
            'onnavanalyze' => null,
            'onplayerpickup' => null,
            'ontimerhigh' => null,
            'ontimerlow' => null,
            'ontouchedactiveweapon' => null,
            'onusecancelled' => null,
            'onusefinished' => null,
            'onusestarted' => null,
            'postspawndirection' => 'vector',
            'postspawndirectionvariance' => 'float',
            'postspawninheritangles' => 'int',
            'postspawnspeed' => 'int',
            'sensitivity' => 'int',
            'slavename' => null,
            'smoothfactor' => 'int',
            'speaker_dsp_preset' => 'int',
            'speakername' => null,
            'spotlightlength' => 'int',
            'spotlightwidth' => 'int',
            'startmusictype' => 'int',
            'targetentityname' => null,
            'team' => 'int',
            'upgradepack_explosive' => 'int',
            'upgradepack_incendiary' => 'int',
            'upgradepackexplosivedensity' => 'float',
            'upgradepackincendiarydensity' => 'float',
            'volume' => 'int',
            'vscripts' => null,
            'weaponclassname' => null,
            'normal.x' => 'float',
            'normal.y' => 'float',
            'normal.z' => 'float',
            'affectsflow' => 'int',
            'filter01' => null,
            'filter02' => null,
            'filtertype' => 'int',
            'grenadelauncherdensity' => 'float',
            'lowpriority' => 'int',
            'maxthenanydispatchdist' => 'int',
            'onmotionenabled' => null,
            'onspawn' => null,
            'ontakedamage' => null,
            'blenddeltamultiplier' => 'int',
            'branch01' => null, 'branch02' => null, 'branch03' => null, 'branch04' => null, 'branch05' => null,
            'branch06' => null, 'branch07' => null, 'branch08' => null,
            'crouch' => 'int',
            'damageforce' => 'vector',
            'desiredtimescale' => 'float',
            'finalestart' => null,
            'haloscale' => 'float',
            'interp_time' => 'float',
            'lagcompensate' => 'int',
            'minblendrate' => 'float',
            'nozzle' => null,
            'onalltrue' => null,
            'onbeginfade' => null,
            'onclose' => null,
            'oncooppostio' => null,
            'onfullyclosed' => null,
            'onfullyopen' => null,
            'onitempickedup' => null,
            'onmultinewmap' => null,
            'onmultinewround' => null,
            'onscavengeintensitychanged' => null,
            'onscavengematchstart' => null,
            'onscavengeovertimestart' => null,
            'onscavengepostio' => null,
            'onscavengeroundstart' => null,
            'onscavengetimerexpired' => null,
            'onsurvivalpostio' => null,
            'onteamscored' => null,
            'target_ent' => null,
            'target_entity' => null,
            'cheapwaterenddistance' => 'float',
            'cheapwaterstartdistance' => 'float',
            'gustdirchange' => 'int',
            'gustduration' => 'int',
            'maxgust' => 'int',
            'maxgustdelay' => 'int',
            'maxwind' => 'int',
            'mingust' => 'int',
            'mingustdelay' => 'int',
            'minwind' => 'int',
            'windradius' => 'float',
            '_minlight' => 'float',
            'bank' => 'int',
            'group02' => null,
            'group03' => null,
            'group04' => null,
            'group05' => null,
            'group06' => null,
            'group07' => null,
            'group08' => null,
            'group09' => null,
            'group10' => null,
            'group11' => null,
            'group12' => null,
            'group13' => null,
            'group14' => null,
            'group15' => null,
            'group16' => null,
            'height' => 'int',
            'movesoundmaxpitch' => 'int',
            'movesoundmaxtime' => 'int',
            'movesoundminpitch' => 'int',
            'movesoundmintime' => 'int',
            'noise1' => null,
            'noise2' => null,
            'ondemomapspawn' => null,
            'onin' => null,
            'onkilled' => null,
            'returnspeed' => 'float',
            'startdirection' => 'int',
            'thinkfunction' => null,
            'traillength' => 'int',
            'velocitytype' => 'int',
            'wheels' => 'int',
            'notsolid' => 'int',
            'ontrigger_' => null,
            'preferredcarryangles' => 'vector',
            'adrenalinepresence' => 'int',
            'disappearmaxdist' => 'int',
            'disappearmindist' => 'int',
            'gibangles' => 'vector',
            'gibanglevelocity' => 'int',
            'gibgravityscale' => 'int',
            'healthmax' => 'int',
            'healthmin' => 'int',
            'm_flgiblife' => 'float',
            'm_flvariance' => 'float',
            'm_flvelocity' => 'float',
            'm_igibs' => 'int',
            'massoverride' => 'int',
            'onanimationdone' => null,
            'onconvert' => null,
            'onfail' => null,
            'onout' => null,
            'shootmodel' => 'path',
            'shootsounds' => 'int',
            'simulation' => 'int',
            'configurableweaponclusterrange' => 'int',
            'configurableweapondensity' => 'float',
            'finaleescapestarted' => null,
            'firstusedelay' => 'float',
            'firstusestart' => null,
            'magnumdensity' => 'float',
            'oncustompanicstagefinished' => null,
            'onlightoff' => null,
            'onlighton' => null,
            'usedelay' => 'float',
            'attach1' => null,
            'coldworld' => 'int',
            'directionentityname' => null,
            'forcelimit' => 'int',
            'gametitle' => 'int',
            'hingeaxis' => 'vector',
            'hingefriction' => 'float',
            'maxoccludeearea' => 'float',
            'maxoccludeearea_x360' => 'float',
            'maxsoundthreshold' => 'int',
            'minoccluderarea' => 'float',
            'minoccluderarea_x360' => 'float',
            'minpropscreenwidth' => 'int',
            'minsoundthreshold' => 'int',
            'newunit' => 'int',
            'position0' => null,
            'position1' => null,
            'position2' => null,
            'reversalsoundthresholdlarge' => 'float',
            'reversalsoundthresholdmedium' => 'float',
            'reversalsoundthresholdsmall' => 'float',
            'startdark' => 'int',
            'systemloadscale' => 'float',
            'teleportfollowdistance' => 'int',
            'torquelimit' => 'float',
            'allownewgibs' => 'int',
            'damagescale' => 'float',
            'fireattack' => 'int',
            'firesize' => 'int',
            'firetype' => 'int',
            'ignitionpoint' => 'int',
            'maxpieces' => 'int',
            'maxpiecesdx8' => 'int',
            'escapevehicleleaving' => null,
            'maxpitch' => 'float',
            'maxyaw' => 'float',
            'minpitch' => 'float',
            'comparevalue' => 'int',
            'distribution' => 'int',
            'in2' => 'int',
            'level' => 'float',
            'mixlayername' => null,
            'onchangelevel' => null,
            'ongreaterthan' => null,
            'out1' => 'int',
            'outvalue' => null,
            'soundcloseoverride' => null,
            'soundmoveoverride' => null,
            'soundopenoverride' => null,
            'xfriction' => 'float',
            'xmax' => 'float',
            'xmin' => 'float',
            'yfriction' => 'float',
            'ymax' => 'float',
            'ymin' => 'float',
            'zfriction' => 'float',
            'zmax' => 'float',
            'zmin' => 'float',
            'error' => 'int',
            'fragility' => 'int',
            'in1' => 'int',
            'lowerleft' => 'vector',
            'lowerright' => 'vector',
            'out2' => 'int',
            'surfacetype' => 'int',
            'upperleft' => 'vector',
            'upperright' => 'vector',
            'maxdelay' => 'float',
            'on20secondstomob' => null,
            'finalepause' => null,
            'ondemomapspawn_disabled' => null,
            'filterinfectedclass' => 'int',
            'onallfalse' => null,
            'onmixed' => null,
            'ignoredclass' => 'int',
            'iradiusoverride' => 'int',
            'overridescript' => null,
            'character' => 'int',
            'eventname' => null,
            'hint_allow_nodraw_target' => 'int',
            'hint_alphaoption' => 'int',
            'hint_auto_start' => 'int',
            'hint_color' => 'vector',
            'hint_forcecaption' => 'int',
            'hint_icon_offscreen' => null,
            'hint_icon_offset' => 'int',
            'hint_icon_onscreen' => null,
            'hint_nooffscreen' => 'int',
            'hint_pulseoption' => 'int',
            'hint_range' => 'int',
            'hint_shakeoption' => 'int',
            'hint_static' => 'int',
            'hint_timeout' => 'int',
            'idlemodifier' => 'float',
            'onstartled' => null,
            'attackonspawn' => 'int',
            'auto_disable' => 'int',
            'beamsprite' => 'path',
            'canobstructnav' => 'int',
            'glowforteam' => 'int',
            'glowrangemin' => 'float',
            'halosprite' => 'path',
            'issacrificefinale' => 'int',
            'occludernumber' => 'int',
            'onescapeimpossible' => null,
            'onreachedfloor' => null,
            'onunpressed' => null,
            'onuserdefinedscriptevent1' => null,
            'position3' => null,
            'position4' => null,
            'recheckbreakables' => 'int',
            'rockdamageoverride' => 'int',
            'rocktargetname' => null,
            'stairs' => 'int',
            'startactive' => 'int',
            'startglowing' => 'int',
            'use_string' => null,
            'weapondensity' => 'float',
            'basepiece' => 'path',
            'damagemod' => 'float',
            'detonateparticles' => null,
            'detonatesound' => null,
            'flyingparticles' => null,
            'flyingpiece01' => 'path',
            'ignoreplayers' => 'int',
            'onrandom01' => null, 'onrandom02' => null, 'onrandom03' => null, 'onrandom04' => null,
            'onrandom05' => null,
            'onscavengespawn' => null,
            'onspawntank' => null,
            'position5' => null,
            'position6' => null,
            'targetarc' => 'float',
            'targetrange' => 'float',
            'targetteam' => 'int',
            'weapontype' => 'int',
            'yaw_speed' => 'float',
            'angleoverride' => null,
            'basespread' => 'float',
            'basisnormal' => 'vector',
            'basisorigin' => 'vector',
            'basisu' => 'vector',
            'basisv' => 'vector',
            'deceleration' => 'float',
            'delay' => 'float',
            'disappeardist' => 'int',
            'emittime' => 'float',
            'endcolor' => 'vector',
            'endsize' => 'float',
            'endu' => 'float',
            'endv' => 'float',
            'fadeduration' => 'float',
            'filterclass' => null,
            'finalelost' => null,
            'firesprite' => 'path',
            'force' => 'float',
            'jetlength' => 'float',
            'lifetime' => 'float',
            'mainsoundscapename' => null,
            'maxdirectedspeed' => 'float',
            'mindirectedspeed' => 'float',
            'nogibshadows' => 'int',
            'onanimationbegun' => null,
            'oncompletion' => null,
            'onfirestart' => null,
            'onfirestop' => null,
            'opacity' => 'float',
            'overlayid' => 'int',
            'position7' => null,
            'rate' => 'float',
            'roll' => 'float',
            'rollspeed' => 'float',
            'sequence' => 'int',
            'sides' => 'int',
            'smokematerial' => 'path',
            'smokesprite' => 'path',
            'spawnradius' => 'float',
            'spawnrate' => 'float',
            'spreadspeed' => 'float',
            'startclosesound' => null,
            'startcolor' => 'vector',
            'startsize' => 'float',
            'startu' => 'float',
            'startv' => 'float',
            'twist' => 'float',
            'useduration' => 'float',
            'uv0' => 'vector',
            'uv1' => 'vector',
            'uv2' => 'vector',
            'uv3' => 'vector',
            'windangle' => 'float',
            'windspeed' => 'float',
            'hint_target' => null,
            'onitemspawn' => null,
            'ondamaged' => null,
            'onpaniceventfinished' => null,
            'rotation' => 'float',
            'soundunlockedoverride' => null,
            'additionaliterations' => 'int',
            'interpolatepositiontoplayer' => 'int',
            'onignite' => null,
            'fadein' => 'float',
            'fadeout' => 'float',
            'finalepause_' => null,
            'ontimer_' => null,
            'usestart_' => null,
            'chaptertitle' => null,
            'scene0' => null, 'scene1' => null, 'scene2' => null, 'scene3' => null, 'scene4' => null, 'scene5' => null,
            'vmex_bspname' => null,
            'vmex_note' => null,
            'vmex_time' => null,
        ),
    );


    /**
     * @param  string $property
     * @return boolean
     */
    public function propertyExists($property)
    {
        return (array_key_exists(strtolower($property), $this->_config['property']));
    }


    
    /**
     * @param  string $property
     * @param  string $value
     * @return array    associative:
     *                     'errors' => [],
     *                     'warnings' => [],
     *                     'validates' => (bool/null)
     *                     'type' => string (if validated as anything)
     */
    public function validatePropertyValue($property, $value)
    {
        if (    is_null($this->_config)
            ||  !is_array($this->_config)
            ||  !isset($this->_config['property'])
        ) {
            throw new Exception("StripperConfig->Config array empty or incomplete.");
        }

        // return array
        $validate = array(
            'validates' =>  null,
            'errors' =>     array(),
            'warnings' =>   array(),
            'type' =>       null,
        );

        $property = strtolower($property);
        $trimvalue = trim($value);
        
        if (preg_match('/\s/', $property)) {
            $validate['warnings'][] = sprintf("Whitespace in property name: '%s'.", $property);
        }

        // whitespace in value
        if (strlen($trimvalue) != strlen($value)) {
            $validate['warnings'][] = sprintf("Whitespace surrounding value for property ('%s'): '%s'.",
                $property, $value);
        }

        // empty value?
        if (!strlen($trimvalue)) {
            // only warn if config set
            if ($this->warnOnEmptyValue) {
                $validate['warnings'][] = sprintf("Found empty/null property value for ('%s').", $property, $value);
            }
            return $validate;
        }

        // is it a known type?
        if (!isset($this->_config['property'][$property])) {
            return $validate;
        }

        // assume correct, switch below catches problems
        $validate['validates'] = true;

        // does its value validate?
        switch ($this->_config['property'][$property]) {

            case 'int':
            case 'bool':
                if (!preg_match('/^[0-9-]+$/', $trimvalue)) {
                    $validate['errors'][] = sprintf("Incorrect value for integer/boolean property ('%s'): '%s'.",
                        $property, $value);
                    $validate['validates'] = false;
                }
                break;

            case 'float':
                if (!preg_match('/^-?[0-9]*\.*[0-9]*+$/', $trimvalue)) {
                    $validate['errors'][] = sprintf("Incorrect value for float property ('%s'): '%s'.",
                        $property, $value);
                    $validate['validates'] = false;
                }
                break;

            case 'alpha':   // including _
                if (!preg_match('/^[a-z_0-9]+$/i', $trimvalue)) {
                    $validate['warnings'][] = sprintf("Illegal characters used for alphanumeric property ('%s'): '%s'."
                        .   " (use only a-z or _)", $property, $value);
                    $validate['validates'] = false;
                }
                break;

            case 'path':
                if (strrpos($trimvalue, '\\') !== false) {
                    $validate['warnings'][] = sprintf("Found backslash (\\) in path property ('%s'): '%s'."
                        .   " Forward slashes (/) are recommended.", $property, $value);
                    $validate['validates'] = false;
                }
                else if (!preg_match('/^[a-z0-9_\/\.\*\' -]+$/i', $trimvalue)) {
                    $validate['warnings'][] = sprintf("Illegal characters used in path property ('%s'): '%s'."
                        .   " (use only a-z, _, 0-9, -, /, *, ', . and space)", $property, $value);
                    $validate['validates'] = false;
                }
                else if (strpos($trimvalue, '*') === false && !preg_match('/\.[a-z0-9_]+$/i', $trimvalue)) {
                    $validate['warnings'][] = sprintf(
                            "Path property ('%s') without filetype: '%s'."
                            .   " This may be fine for materials.",
                            $property, $value);
                }
                break;

            case 'vector':
                if (!preg_match('/^((-?[0-9\.]|e-)+\s+){2}(-?[0-9\.]|e-)+$/', $trimvalue)) {
                    $validate['errors'][] = sprintf("Incorrect value for vector property ('%s'): '%s'."
                        .   " (format is <float> <float> <float>)", $property, $value);
                    $validate['validates'] = false;
                }
                break;

            case 'color':
                if (!preg_match('/^([0-9]+)\s+([0-9]+)\s+([0-9]+)(\s+([0-9]+))?$/sm', $trimvalue, $match)) {
                    $validate['errors'][] = sprintf("Incorrect value for RGBA color property ('%s'): '%s'."
                        .   " (format is <0-255> <0-255> <0-255> <0-255>)", $property, $value);
                    $validate['validates'] = false;
                } elseif (  $match[1] < 0 || $match[1] > 255
                        ||  $match[2] < 0 || $match[2] > 255
                        ||  $match[3]< 0 || $match[3] > 255
                ) {
                    $validate['errors'][] = sprintf("One ore more values out of range for RGBA color property ('%s'):"
                        .   " '%s'. (allowed range is <0-255>)", $property, $value);
                    $validate['validates'] = false;
                }
                break;

            case 'color_rgba':  // 4 int values
                if (!preg_match('/^(-?[0-9]+\s+){3}-?[0-9]+$/sm', $trimvalue)) {
                    $validate['errors'][] = sprintf("Incorrect value for RGBA color property ('%s'): '%s'."
                        .   " (format is <int> <int> <int> <int>)", $property, $value);
                    $validate['validates'] = false;
                }
                break;
            
            case 'vector_double':   // axis
                if (!preg_match('/^((-?[0-9\.]|e-)+\s+){2}(-?[0-9\.]|e-)+\s*'
                    .   '(,\s*((-?[0-9\.]|e-)+\s+){2}(-?[0-9\.]|e-)+)?$/sm', $trimvalue)
                ) {
                    $validate['errors'][] = sprintf("Incorrect value for double vector property ('%s'): '%s'."
                        .   " (format is <float> <float> <float>[, <float> <float> <float>])", $property, $value);
                    $validate['validates'] = false;
                }
                break;

            // default omitted on purpose
        }

        if ($validate['validates'] !== false) {
            $validate['type'] = $this->_config['property'][$property];
        }

        return $validate;
    }
}
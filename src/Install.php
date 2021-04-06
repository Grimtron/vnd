<?php
namespace Drupal\vnd;

/**
 * Stellt statische Hilfsmethoden zum Durchführen von Modul-Updates bereit.
 */
class Install
{
    /**
     * Legt eine neue Entität an.
     *
     * @param string $entity Name der Entität
     * @return string OK im Erfolgsfall, Fehlermeldung sonst.
     */
    public static function InstallEntity(string $entity)
    {
        if (!\Drupal::database()->schema()->tableExists($entity))
        {
            \Drupal::entityTypeManager()->clearCachedDefinitions();
            \Drupal::entityDefinitionUpdateManager()
            ->installEntityType(\Drupal::entityTypeManager()->getDefinition($entity));

            return 'OK';
        }
        else 
        {
            return 'Process Status entity already exists';
        } 
    }

    public static function UninstallEntity($entityName)
    {
        $entity_update_manager = \Drupal::entityDefinitionUpdateManager();
        $entity_type = $entity_update_manager->getEntityType($entityName);
        $entity_update_manager->uninstallEntityType($entity_type);
    }

    /**
     * Add a column for an entity
     *
     * @param string $entityTypeId ID of entity to which the column should be added
     * @param string $fieldName Name of new field
     * @param string $fieldType Type of new field, e.g. integer
     * @param string $label Short description of new field
     * @return void
     */
    public static function AddColumn($entityTypeId, $fieldName, $fieldType, $label)
    {
        $field_storage_definition = \Drupal\Core\Field\BaseFieldDefinition::create($fieldType)
        ->setLabel($label)
        ->setDescription($label);

        \Drupal::entityDefinitionUpdateManager()->installFieldStorageDefinition($fieldName, $entityTypeId, $entityTypeId, $field_storage_definition);
    }

    /**
     * Adds a string column to an entity
     *
     * @param string $entityTypeId ID of entity to which the column should be added
     * @param string $fieldName Name of new field
     * @param string $label Short description of new field
     * @return void
     */
    public static function AddStringColumn($entityTypeId, $fieldName, $label)
    {
        $field_storage_definition = \Drupal\Core\Field\BaseFieldDefinition::create('string')
        ->setLabel($label)
        ->setDescription($label)
        ->setSettings(
            [
                'default_value' => '',
                'max_length' => 1024,
                'text_processing' => 0,
            ]
            );       

        \Drupal::entityDefinitionUpdateManager()->installFieldStorageDefinition($fieldName, $entityTypeId, $entityTypeId, $field_storage_definition);
    }

    /**
     * Adds an integer column to an entity
     *
     * @param string $entityTypeId ID of entity to which the column should be added
     * @param string $fieldName Name of new field
     * @param string $label Short description of new field
     * @return void
     */
    public static function AddIntColumn($entityTypeId, $fieldName, $label)
    {
        $field_storage_definition = \Drupal\Core\Field\BaseFieldDefinition::create('integer')
        ->setLabel($label)
        ->setDescription($label)
        ->setSettings(['max_length' => 11]);

        \Drupal::entityDefinitionUpdateManager()->installFieldStorageDefinition($fieldName, $entityTypeId, $entityTypeId, $field_storage_definition);
    }
}
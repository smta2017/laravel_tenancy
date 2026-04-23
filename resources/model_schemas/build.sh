
echo "Starting ..."

# php artisan vendor:publish --provider="InfyOm\Generator\InfyOmGeneratorServiceProvider"


# php artisan infyom:api CaseState --fieldsFile='resources/model_schemas/CaseState.json' -n
# php artisan infyom:api AttributeOpponent --fieldsFile='resources/model_schemas/AttributeOpponent.json' -n
# php artisan infyom:api Band  --fieldsFile='resources/model_schemas/Band.json' -n
# php artisan infyom:api Contract  --fieldsFile='resources/model_schemas/Contract.json' -n
# php artisan infyom:api ContractBand  --fieldsFile='resources/model_schemas/ContractBand.json' -n
# php artisan infyom:api CaseType --fieldsFile='resources/model_schemas/CaseType.json' -n
# php artisan infyom:api TheCase  --fieldsFile='resources/model_schemas/TheCase.json' -n
# php artisan infyom:api LitigationAuthorityType --fieldsFile='resources/model_schemas/LitigationAuthorityType.json' -n
# php artisan infyom:api LitigationLevel --fieldsFile='resources/model_schemas/LitigationLevel.json' -n
# php artisan infyom:api LitigationAuthority --fieldsFile='resources/model_schemas/LitigationAuthority.json' -n
# php artisan infyom:api CaseDetails  --fieldsFile='resources/model_schemas/CaseDetails.json' -n
# php artisan infyom:api Attach  --fieldsFile='resources/model_schemas/Attach.json' -n
# php artisan infyom:api Client  --fieldsFile='resources/model_schemas/Client.json' -n
# php artisan infyom:api ClientAttach  --fieldsFile='resources/model_schemas/ClientAttach.json' -n
# php artisan infyom:api CaseDetailsClient  --fieldsFile='resources/model_schemas/CaseDetailsClient.json' -n

# ------------------------------------------------------------------------------------------------------------------------
php artisan infyom:api EventState  --fieldsFile='resources/model_schemas/EventState.json' -n
php artisan infyom:api EventType  --fieldsFile='resources/model_schemas/EventType.json' -n
php artisan infyom:api CaseDetailEvent  --fieldsFile='resources/model_schemas/CaseDetailEvent.json' -n






# php artisan infyom:api_scaffold ProcedureType --fieldsFile='resources/model_schemas/ProcedureType.json' -n

# php artisan vendor:publish --provider="InfyOm\Generator\InfyOmGeneratorServiceProvider"
# php artisan infyom:publish

php artisan migrate:fresh --seed
echo "Finished!"


 

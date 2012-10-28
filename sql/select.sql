select * from hm_param as a left join hm_user_travelpreferences as b on a.param_id=b.trvint_param_id where a.param_category_id='Travel_with'



trvint_id	trvint_user_id	trvint_cat	trvint_param_id	trvint_rate


param_id	param_type	param_category_id	param_category_desc	param_action 	param_published


select a.param_category_desc,b.trvint_id, b.trvint_user_id
, a.param_category_id	, a.param_id, b.trvint_rate from hm_param a left join   hm_user_travelpreferences b on a.param_id=b.trvint_param_id and b.trvint_user_id=10067
where a.param_category_id='Travel_with' and 
param_category_desc <>''

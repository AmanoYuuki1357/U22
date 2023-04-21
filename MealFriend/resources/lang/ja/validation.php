<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'          => ':attributeを承認してください。',
    'accepted_if'       => ':otherが:valueの場合、:attributeを承認する必要があります。',
    'active_url'        => ':attributeは有効なURLではありません。',
    'after'             => ':attributeは:dateより後の日付でなければなりません。',
    'after_or_equal'    => ':attributeは:date 以降の日付でなければなりません。',
    'alpha'             => ':attributeには文字を含める必要があります。',
    'alpha_dash'        => ':attributeは英数字とハイフン、アンダーバーのみで入力してください。',
    'alpha_num'         => ':attributeは英数字で入力してください。',
    'array'             => ':attributeは配列で入力してください。',
    'ascii'             => ':attribute には、半角英数字と記号のみを含める必要があります。',
    'before'            => ':attributeは:dateより前の日付を入力してください。',
    'before_or_equal'   => ':attributeは:date以前の日付を入力してください。',
    'between' => [
        'array'     => ':attributeは:min〜:max個の範囲内にしてください。',
        'file'      => ':attributeは:min〜:max KBのファイルを選択してください。',
        'numeric'   => ':attributeは:min〜:maxの範囲で入力してください。',
        'string'    => ':attributeは:min〜:max文字の範囲で入力してください。',
    ],
    'boolean'           => ':attributeはtrueかfalseにしてください。',
    'confirmed'         => ':attributeが確認用の内容と一致しません。',
    'current_password'  => 'パスワードが正しくありません。',
    'date'              => ':attributeを正しい日付で入力してください。',
    'date_equals'       => ':attributeを:dateと一致するよう入力してください。',
    'date_format'       => ':attributeの書式を:formatに沿って入力してください。',
    'decimal'           => ':attribute には、:decimal 小数点以下の桁数が必要です。',
    'declined'          => ':attribute は拒否されました。',
    'declined_if'       => ':other が :value の場合、:attribute を拒否されます。',
    'different'         => ':attributeと:otherは異なるものを入力してください。',
    'digits'            => ':attributeは:digits桁で入力してください。',
    'digits_between'    => ':attributeは:min〜:max桁で入力してください。',
    'dimensions'        => ':attributeの画像サイズが不正です。',
    'distinct'          => ':attributeが重複しています。',
    'doesnt_end_with'   => ':attribute は、次のいずれかで終了することはできません。: :values',
    'doesnt_start_with' => ':attribute は、次のいずれかで開始することはできません。: :values',
    'email'             => ':attributeを正しい形式で入力してください。',
    'ends_with'         => ':attributeを:valuesで終わるよう入力してください。: :values',
    'enum'              => '選択された:attributeは無効です。',
    'exists'            => '選択した値が不正です。',
    'file'              => ':attributeはファイルを選択してください。',
    'filled'            => ':attributeを入力してください。',
    'gt' => [
        'array'     => ':attributeは:value個より多くしてください。',
        'file'      => ':attributeは:value KBより大きいファイルを選択してください。',
        'numeric'   => ':attributeは:valueより多く入力してください。',
        'string'    => ':attributeは:value文字より多く入力してください。',
    ],
    'gte' => [
        'array'     => ':attributeは:value個以上にしてください。',
        'file'      => ':attributeは:value KB以上のファイルを選択してください。',
        'numeric'   => ':attributeは:value以上で入力してください。',
        'string'    => ':attributeは:value文字以上入力してください。',
    ],
    'image'             => ':attributeは画像にしてください。',
    'in'                => ':attributeは不正です。',
    'in_array'          => ':attributeは:otherの範囲外です。',
    'integer'           => ':attributeは数字で入力してください。',
    'ip'                => ':attributeはIPアドレス形式で入力してください。',
    'ipv4'              => ':attributeはIPv4形式で入力してください。',
    'ipv6'              => ':attributeはIPv6形式で入力してください。',
    'json'              => ':attributeはJSON形式で入力してください。',
    'lowercase'         => ':attribute は小文字でなければなりません。',
    'lt' => [
        'array'     => ':attributeは:value個より少なくしてください。',
        'file'      => ':attributeは:value KBより小さいファイルを選択してください。',
        'numeric'   => ':attributeは:valueより少なく入力してください。',
        'string'    => ':attributeは:value文字より少なく入力してください。',
    ],
    'lte' => [
        'array'     => ':attributeは:value個以下にしてください。',
        'file'      => ':attributeは:value KB以下のファイルを選択してください。',
        'numeric'   => ':attributeは:value以下で入力してください。',
        'string'    => ':attributeは:value文字以下入力してください。',
    ],
    'mac_address'       => ':attributeは有効なMACアドレスでなければなりません.',
    'max' => [
        'array'     => ':attributeは:max個以下にしてください。',
        'file'      => ':attributeは:max KB以下のファイルを選択してください。',
        'numeric'   => ':attributeは:max以下で入力してください。',
        'string'    => ':attributeは:max文字以下入力してください。',
    ],
    'max_digits'        => ':attribute は :max 桁を超えてはなりません.',
    'mimes'             => ':attribute は、タイプ: :values のファイルでなければなりません。',
    'mimetypes'         => ':attribute は、タイプ: :values のファイルでなければなりません。',
    'min' => [
        'array'     => ':attributeは:min個以上にしてください。',
        'file'      => ':attributeは:min KB以上のファイルを選択してください。',
        'numeric'   => ':attributeは:min以上で入力してください。', 
        'string'    => ':attributeは:min文字以上入力してください。',
    ],
    'min_digits'        => ':attribute には、少なくとも :min 桁が必要です。',
    'missing'           => ':attribute フィールドが欠落している必要があります。',
    'missing_if'        => ':other が :value の場合、:attribute フィールドが欠落している必要があります。',
    'missing_unless'    => ':other が :value でない限り、:attribute フィールドは欠落している必要があります。',
    'missing_with'      => ':values が存在する場合、:attribute フィールドは欠落している必要があります。',
    'missing_with_all'  => ':values が存在する場合、:attribute フィールドは欠落している必要があります。',
    'multiple_of'       => ':attribute は :value の倍数でなければなりません。',
    'not_in'            => ':attributeは不正です。',
    'not_regex'         => ':attributeの書式が不正です。',
    'numeric'           => ':attributeは数字で入力してください。',
    'password' => [
        'letters'       => ':attribute には、少なくとも 1 つの文字が含まれている必要があります。',
        'mixed'         => ':attribute には、少なくとも 1 つの大文字と 1 つの小文字を含める必要があります。',
        'numbers'       => ':attribute には、少なくとも 1 つの数値が含まれている必要があります。',
        'symbols'       => ':attribute には、少なくとも 1 つのシンボルが含まれている必要があります。',
        'uncompromised' => '指定された :attribute がデータ リークに含まれています。 別の属性を選択してください。',
    ],
    'present'           => ':attributeは存在する必要があります。',
    'prohibited'        => ':attribute フィールドは禁止されています。',
    'prohibited_if'     => ':other が :value の場合、:attribute フィールドは禁止されています。',
    'prohibited_unless' => ':values に :other がない限り、:attribute フィールドは禁止されています。',
    'prohibits'         => ':attribute フィールドは、:other の存在を禁止します。',
    'regex'             => ':attributeの書式が不正です。',
    'required'          => ':attributeを入力してください。',
    'required_array_keys' => ':attribute フィールドには、:values のエントリが含まれている必要があります。',
    'required_if'       => ':otherが:valueの時、:attributeを入力してください。',
    'required_if_accepted' => ':other が受け入れられる場合、:attribute フィールドは必須です。',
    'required_unless'   => ':otherが:valuesでない時、:attributeを入力してください。',
    'required_with'     => ':values が存在する場合、:attribute フィールドは必須です。',
    'required_with_all' => ':values が存在する場合、:attribute フィールドは必須です。',
    'required_without'  => ':values が存在しない場合、:attribute フィールドは必須です。',
    'required_without_all' => ':values が存在しない場合、:attribute フィールドは必須です。',
    'same'              => ':attributeと:otherが一致するよう入力してください。',
    'size' => [
        'array'     => ':attributeは:size個にしてください。',
        'file'      => ':attributeは:size KBのファイルを選択してください。',
        'numeric'   => ':attributeは:sizeで入力してください。',
        'string'    => ':attributeは:size文字で入力してください。',
    ],
    'starts_with'       => ':attributeを:valuesから始まるよう入力してください。',
    'string'            => ':attributeは文字で入力してください。',
    'timezone'          => ':attributeを正しいタイムゾーンで入力してください。',
    'unique'            => ':attributeは既に取得されているため、異なるものを入力してください。',
    'uploaded'          => ':attributeはアップロードに失敗しました。',
    'uppercase'         => ':attribute は大文字でなければなりません。',
    'url'               => ':attributeを正しいURLで入力してください。',
    'ulid'              => ':attributeを正しいULIDで入力してください。',
    'uuid'              => ':attributeを正しいUUIDで入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード'
    ],

];

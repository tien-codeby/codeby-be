{{--@php
    $user = ['name'=>'Tien', 'email'=>'tien@gmail.com'];
    $reset_url = join('', [
        config('app.fontend_url'),
        '/ResetPasswordPage?',
        http_build_query([
            'email'=>$user['email'],
            'reset_code'=>base64_encode('123')
        ])
]);
@endphp--}}
<table border="0" cellspacing="0" cellpadding="0" align="center" style="border-collapse: collapse;">
    <tbody>
    <tr>
        <td style="font-family: Helvetica Neue, Helvetica, Lucida Grande, tahoma, verdana, arial, sans-serif; background: #ffffff;">
            <table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                <tbody>
                <tr>
                    <td height="20" style="line-height: 20px;" colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td height="1" colspan="3" style="line-height: 1px;">
                        <span style="color: #ffffff; font-size: 1px; opacity: 0;">We received a request to reset your {{config('app.name')}} password.</span>
                    </td>
                </tr>
                <tr>
                    <td width="15" style="display: block; width: 15px;">&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        <table border="0" width="100%" cellspacing="0" cellpadding="0"
                               style="border-collapse: collapse;">
                            <tbody>
                            <tr>
                                <td height="15" style="line-height: 15px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="32" align="left" valign="middle" style="font-weight:bold; font-size: 16px; height: 32px; line-height: 0px;">
                                    {{config('app.name')}}
                                </td>
                            </tr>
                            <tr style="border-bottom: solid 1px #e5e5e5;">
                                <td height="15" style="line-height: 15px;">&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="15" style="display: block; width: 15px;">&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td width="15" style="display: block; width: 15px;">&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        <table border="0" width="100%" cellspacing="0" cellpadding="0"
                               style="border-collapse: collapse;">
                            <tbody>
                            <tr>
                                <td height="4" style="line-height: 4px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                                <span
                                                        style="font-family: Helvetica Neue, Helvetica, Lucida Grande, tahoma, verdana, arial, sans-serif; font-size: 16px; line-height: 21px; color: #141823;"
                                                >
                                                    <span style="font-size: 15px;">
                                                        <p></p>
                                                        <div style="margin-top: 16px; margin-bottom: 20px;">Hi {{$user['name']}},</div>
                                                        <div>We received a request to reset your {{config('app.name')}} password.</div>
                                                        Enter the following password reset code:
                                                        <p></p>
                                                        <table border="0" cellspacing="0" cellpadding="0"
                                                               style="border-collapse: collapse; width: max-content; margin-top: 20px; margin-bottom: 20px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td
                                                                            style="
                                                                            font-size: 11px;
                                                                            font-family: LucidaGrande, tahoma, verdana, arial, sans-serif;
                                                                            padding: 14px 32px 14px 32px;
                                                                            background-color: #f2f2f2;
                                                                            border-left: 1px solid #ccc;
                                                                            border-right: 1px solid #ccc;
                                                                            border-top: 1px solid #ccc;
                                                                            border-bottom: 1px solid #ccc;
                                                                            text-align: center;
                                                                            border-radius: 3px;
                                                                            display: block;
                                                                            border: 1px solid #1877f2;
                                                                            background: #e7f3ff;
                                                                        "
                                                                    >
                                                                        <span
                                                                                style="font-family: Helvetica Neue, Helvetica, Lucida Grande, tahoma, verdana, arial, sans-serif; font-size: 16px; line-height: 21px; color: #141823;"
                                                                        >
                                                                            <span style="font-size: 17px; font-family: Roboto; font-weight: 700; margin-left: 0px; margin-right: 0px;">{{$code}}</span>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        Alternatively, you can directly change your password.
                                                        <table border="0" width="100%" cellspacing="0" cellpadding="0"
                                                               style="border-collapse: collapse;">
                                                            <tbody>
                                                                <tr>
                                                                    <td height="20"
                                                                        style="line-height: 20px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="middle">
                                                                        <a
                                                                                href="{{$reset_url}}"
                                                                                style="color: #3b5998; text-decoration: none;"
                                                                                target="_blank"
                                                                        >
                                                                            <table border="0" width="100%"
                                                                                   cellspacing="0" cellpadding="0"
                                                                                   style="border-collapse: collapse;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td
                                                                                                style="
                                                                                                border-collapse: collapse;
                                                                                                border-radius: 3px;
                                                                                                text-align: center;
                                                                                                display: block;
                                                                                                border: none;
                                                                                                background: #1877f2;
                                                                                                padding: 6px 20px 10px 20px;
                                                                                            "
                                                                                        >
                                                                                            <a
                                                                                                    href="{{$reset_url}}"
                                                                                                    style="color: #3b5998; text-decoration: none; display: block;"
                                                                                                    target="_blank"
                                                                                            >
                                                                                                <center>
                                                                                                    <font size="3">
                                                                                                        <span
                                                                                                                style="
                                                                                                                font-family: Helvetica Neue, Helvetica, Lucida Grande, tahoma, verdana, arial, sans-serif;
                                                                                                                white-space: nowrap;
                                                                                                                font-weight: bold;
                                                                                                                vertical-align: middle;
                                                                                                                color: #ffffff;
                                                                                                                font-weight: 500;
                                                                                                                font-family: Roboto-Medium, Roboto, -apple-system, BlinkMacSystemFont, Helvetica Neue, Helvetica, Lucida Grande, tahoma, verdana,
                                                                                                                    arial, sans-serif;
                                                                                                                font-size: 17px;
                                                                                                            "
                                                                                                        >
                                                                                                            Change&nbsp;Password
                                                                                                        </span>
                                                                                                    </font>
                                                                                                </center>
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="8" style="line-height: 8px;">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="20"
                                                                        style="line-height: 20px;">&nbsp;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <br/>
                                                        <div>
                                                            <span style="color: #333333; font-weight: bold;">Didn't request this change?</span>
                                                        </div>
                                                        If you didn't request a new password,
                                                        <a
                                                                href="{{config('app.frontend_url')}}"
                                                                style="color: #0a7cff; text-decoration: none;"
                                                                target="_blank"
                                                        >
                                                            let us know
                                                        </a>
                                                        .
                                                    </span>
                                                </span>
                                </td>
                            </tr>
                            <tr>
                                <td height="50" style="line-height: 50px;">&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="15" style="display: block; width: 15px;">&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td width="15" style="display: block; width: 15px;">&nbsp;&nbsp;&nbsp;</td>
                    <td>
                        <table border="0" width="100%" cellspacing="0" cellpadding="0" align="left"
                               style="border-collapse: collapse;">
                            <tbody>
                            <tr style="border-top: solid 1px #e5e5e5;">
                                <td height="19" style="line-height: 19px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td
                                        style="
                                                    font-family: Roboto-Regular, Roboto, -apple-system, BlinkMacSystemFont, Helvetica Neue, Helvetica, Lucida Grande, tahoma, verdana, arial, sans-serif;
                                                    font-size: 12px;
                                                    color: #8a8d91;
                                                    line-height: 16px;
                                                    font-weight: 400;
                                                "
                                >
                                    This message was sent to <a href="mailto:{{$user['email']}}"
                                                                style="color: #1b74e4; text-decoration: none;"
                                                                target="_blank">{{$user['email']}}</a> at your request.
                                    <br/>
                                    {{config('app.name')}}, Inc.
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="15" style="display: block; width: 15px;">&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td height="20" style="line-height: 20px;" colspan="3">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

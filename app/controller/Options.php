<?php

namespace app\controller;

use support\ErrorCode;
use support\Request;
use app\service\Options as OptionsService;
use support\Response;

class Options
{

    /**
     * @var OptionsService
     */
    private OptionsService $optionsService;

    public function __construct(OptionsService $optionsService)
    {
        $this->optionsService = $optionsService;
    }

    /**
     * 添加配置
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function addOptions(Request $request): Response
    {
        $param = $request->all();
        $res = $this->optionsService->addOptions($param);
        return json(success_response('', $res));
    }

    /**
     * 更新配置
     * @param Request $request
     * @return Response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function updateOptions(Request $request): Response
    {
        $param = $request->all();

        $hasUpdateValue = false;
        foreach (['name', 'code', 'config'] as $field) {
            // 至少有一个字段需要更新
            if (!empty($param[$field])) {
                $hasUpdateValue = true;
                break;
            }
        }

        if ($hasUpdateValue) {
            $res = $this->optionsService->updateOptions($param);
            return json(success_response('', $res));
        } else {
            throw_http_exception('There is no info to modify.', ErrorCode::NoInfoToModify);
        }
    }

    /**
     * 删除配置
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function deleteOptions(Request $request): Response
    {
        $param = $request->all();
        $res = $this->optionsService->deleteOptions($param['id']);
        return json(success_response('', $res));
    }

    /**
     * 通过code获取指定配置
     * @param Request $request
     * @return Response
     * @throws \exception
     */
    public function getOptionsByCode(Request $request): Response
    {
        $param = $request->all();
        $res = $this->optionsService->getOptionsByCode($param['code']);
        return json(success_response('', $res));
    }
}
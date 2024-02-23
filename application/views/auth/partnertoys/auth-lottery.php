<!-- Auth function -->
<div role="main" class="main">
    <div class="container">
        <div class="justify-content-center">
            <div id="memberOrderList">
                <div class="col-12 text-center">
                    <span class="memberTitleMember">LOTTERY<span class="memberTitleLogin">&nbsp;EVENT</span></span>
                </div>
                <div class="memberTitleChinese col-12 text-center">{{ pageTitle }}</div>
                <div v-if="!lottery" class="noneOrder">
                    <span class="">目前無任何抽選資料</span>
                </div>
                <table v-if="lottery" class="table table-striped table-bordered table-hover" id="data-table">
                    <thead class="pc_lottery">
                        <tr class="info">
                            <th class="text-center">抽選名稱</th>
                            <th class="text-center">抽選商品</th>
                            <th class="text-center">中獎狀態</th>
                            <th class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody class="pc_lottery">
                        <tr v-for="self in lottery.slice(pageStart, pageEnd)">
                            <td class="text-center">
                                <p class="lotteryResult">{{ self.name }}</p>
                            </td>
                            <td class="text-center">
                                <p class="lotteryResult">{{ self.product_name }}</p>
                            </td>
                            <td v-if="self.draw_over != 1" class="text-center">
                                <p class="lotteryResult">尚未開獎</p>
                            </td>
                            <td v-if="self.draw_over == 1 && (getLotteryResult(self.id).winner || getLotteryResult(self.id).fill_up)" class="text-center">
                                <p class="lotteryResult">恭喜中獎</p>
                            </td>
                            <td v-if="self.draw_over == 1 && !getLotteryResult(self.id).winner && !getLotteryResult(self.id).fill_up" class="text-center">
                                <p class="lotteryResult">未中獎</p>
                            </td>
                            <td v-if="self.draw_over == 1 && self.lottery_end == 0 && getLotteryResult(self.id).order_state != 'pay_ok' && (getLotteryResult(self.id).winner || getLotteryResult(self.id).fill_up)" class="text-center">
                                <p>
                                    <select v-if="getLotteryProductCombine(self.product_id)" name="lotteryProductCombine" id="lotteryProductCombine" class="lotteryResult">
                                        <option v-for="combine in lottery_product_combine" :key="combine.id" :value="combine.id">{{ combine.name }}</option>
                                    </select>
                                    &nbsp;
                                    <a class="addCartLottery" @click="add_cart_lottery(self.id)">(加入購物車)</a>
                                </p>
                            </td>
                            <td v-else class="text-center">
                                <p class="lotteryResult">#</p>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="mb_lottery">
                        <tr v-for="self in lottery.slice(pageStart, pageEnd)">
                            <td class="remarks text-center">
                                <p>抽選名稱：{{ self.name }}</p>
                                <p>抽選商品：{{ self.product_name }}</p>
                                <p v-if="self.draw_over != 1">
                                    中獎狀態：尚未開獎
                                </p>
                                <p v-if="self.draw_over == 1 && (getLotteryResult(self.id).winner || getLotteryResult(self.id).fill_up)">
                                    中獎狀態：恭喜中獎
                                </p>
                                <p v-if="self.draw_over == 1 && !getLotteryResult(self.id).winner && !getLotteryResult(self.id).fill_up">
                                    中獎狀態：未中獎
                                </p>
                                <p v-if="self.draw_over == 1 && self.lottery_end == 0 && getLotteryResult(self.id).order_state != 'pay_ok' && (getLotteryResult(self.id).winner || getLotteryResult(self.id).fill_up)">
                                    <select v-if="getLotteryProductCombine(self.product_id)" name="lotteryProductCombine" id="lotteryProductCombine" class="lotteryResult">
                                        <option v-for="combine in lottery_product_combine" :key="combine.id" :value="combine.id">{{ combine.name }}</option>
                                    </select>
                                    &nbsp;
                                    <a class="addCartLottery" @click="add_cart_lottery">(加入購物車)</a>
                                </p>
                                <p v-else>#</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php require('pagination.php'); ?>
            </div>
        </div>
    </div>
</div>
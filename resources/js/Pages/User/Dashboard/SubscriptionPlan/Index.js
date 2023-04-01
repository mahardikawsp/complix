import Authenticated from "@/Layouts/Authenticated/Index"
import SubscriptionCard from "@/Components/SubscriptionCard"
import { Inertia } from "@inertiajs/inertia"

export default function SubscriptionPlan({auth, subscriptionPlans}){
    const onSelectSubscription = id => {
        // alert(id)
        Inertia.post(route('user.dashboard.subscriptionPlan.userSubscribe',{
            subscriptionPlan: id
        }));
    }
    return (
        <Authenticated auth={auth}>
                {/* <!-- START: Content --> */}
                    <div className="py-20 flex flex-col items-center">
                        <div className="text-black font-semibold text-[26px] mb-3">
                            Pricing for Everyone
                        </div>
                        <p className="text-base text-gray-1 leading-7 max-w-[302px] text-center">
                            Invest your little money to get a whole new experiences from movies.
                        </p>

                        {/* <!-- Pricing Card --> */}
                        <div className="flex justify-center gap-1 0 mt-[70px]">
                            {/* <!-- Basic --> */}
                            {subscriptionPlans.map((subscriptionPlans) =>(
                                <SubscriptionCard 
                                name={subscriptionPlans.name} 
                                price={subscriptionPlans.price} 
                                durationInMonth={subscriptionPlans.active_period_in_month} 
                                features={JSON.parse(subscriptionPlans.features)}
                                isPremium={subscriptionPlans.name === 'Premium'}
                                key={subscriptionPlans.id}
                                onSelectSubscription={() => onSelectSubscription(subscriptionPlans.id)}
                                 />
                            ))}
                            
                        </div>
                        {/* <!-- /Pricing Card --> */}
                    </div>
                {/* <!-- END: Content --> */}
        </Authenticated>
    )
    
}
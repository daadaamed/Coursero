import math

def change_making(denomination,target):
    cache={}
    def subproblem(i,t): 
        if (i,t) in cache: return cache[(i,t)] #memo
        #compute lowest nbr of coins we need if  choosing to take a coin of current denomination
        val=denomination[i]
        if val>t:
            #current denoination is too large
            choice_take=math.inf
        elif val==t: 
            #target reached
            choice_take=1 
    
        else:
            #take and recursive
            choice_take = 1 + subproblem(i,t-val)

        #compute the lowest nbr of coins we neeed if not taking any more coins
        #coins of  current denomination.
        if i==0:
            #not an option if no more denominations
            choice_leave=math.inf 
        else: 
            #recurse with remaining denomination
            choice_leave=subproblem(i-1,t)
    
        optimal=min(choice_take,choice_leave)
        cache[(i,t)]=optimal
        return optimal
    return subproblem(len(denomination)-1,target)


if __name__ == '__main__':
    print('change_making([1,5,12,19],16)= ' f'{change_making([1,5,12,19],16)}')

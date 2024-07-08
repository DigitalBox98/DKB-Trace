/*****************************************************************************
*
*                                    prioq.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements a priority queue using a heap.
*
* This software is freely distributable. The source and/or object code may be
* copied or uploaded to communications services so long as this notice remains
* at the top of each file.  If any changes are made to the program, you must
* clearly indicate in the documentation and in the programs startup message
* who it was who made the changes. The documentation should also describe what
* those changes were. This software may not be included in whole or in
* part into any commercial package without the express written consent of the
* author.  It may, however, be included in other public domain or freely
* distributed software so long as the proper credit for the software is given.
*
* This software is provided as is without any guarantees or warranty. Although
* the author has attempted to find and correct any bugs in the software, he
* is not responsible for any damage caused by the use of the software.  The
* author is under no obligation to provide service, corrections, or upgrades
* to this package.
*
* Despite all the legal stuff above, if you do find bugs, I would like to hear
* about them.  Also, if you have any comments or questions, you may contact me
* at the following address:
*
*     David Buck
*     22C Sonnet Cres.
*     Nepean Ontario
*     Canada, K2H 8W7
*
*  I can also be reached on the following bulleton boards:
*
*     OMX              (613) 731-3419
*     Mystic           (613) 596-4249  or  (613) 596-4772
*
*  Fidonet:   1:163/109.9
*  Internet:  dbuck@ccs.carleton.ca
*  The "You Can Call Me RAY" BBS    (708) 358-5611
*
*  IBM Port by Aaron A. Collins. Aaron may be reached on the following BBS'es:
*
*     The "You Can Call Me RAY" BBS (708) 358-5611
*     The Information Exchange BBS  (708) 945-5575
*
*****************************************************************************/

#include "frame.h"
#include "dkbproto.h"

#define NUMBER_OF_PRIOQS 20
#define NUMBER_OF_INTERSECTIONS 20

PRIOQ *prioqs;

void pq_init ()
   {
   register int i;
   PRIOQ *new_pq;

   prioqs = NULL;

   for (i = 0 ; i < NUMBER_OF_PRIOQS; i++)
      {
      if ((new_pq = (PRIOQ *) malloc (sizeof (PRIOQ))) == NULL) {
         fprintf (stderr, "\nCannot allocate queues");
         exit(1);
         }
      
      new_pq -> next_pq = prioqs;
      prioqs = new_pq;

      if ((new_pq -> queue = (INTERSECTION *)
            malloc (128 * sizeof (INTERSECTION))) == NULL) {
         fprintf (stderr, "\nCannot allocate queue entries");
         exit(1);
         }
      }
   }

PRIOQ *pq_alloc()
   {
   PRIOQ *allocated_queue;

   if (prioqs == NULL) {
      fprintf (stderr, "\nOut of prioqs");
      exit(1);
      }

   allocated_queue = prioqs;
   prioqs = allocated_queue -> next_pq;
   return (allocated_queue);
   }

void pq_free (pq)
   PRIOQ *pq;
   {
   pq -> next_pq = prioqs;
   prioqs = pq;
   }

PRIOQ *pq_new (index_size)
   int index_size;
   {
   PRIOQ *pq;

   if (index_size > 256)
      return (NULL);

   if ((pq = pq_alloc()) == NULL)
      return (NULL);

   pq -> queue_size = index_size;
   pq -> current_entry = 0;
   return (pq);
   }

void pq_balance(q, entry_pos1)
   PRIOQ *q;
   unsigned int entry_pos1;
   {
   register INTERSECTION *entry1, *entry2;
   INTERSECTION temp_entry;
   register unsigned int entry_pos2;

   entry1 = &q->queue[entry_pos1];

   if ((entry_pos1 * 2 < q->queue_size)
       && (entry_pos1 * 2 <= q -> current_entry))
      {
      if ((entry_pos1*2+1 > q->current_entry) ||
          (q->queue[entry_pos1*2].Depth < q->queue[entry_pos1*2+1].Depth))
         entry_pos2 = entry_pos1*2;
      else
         entry_pos2 = entry_pos1*2+1;

      entry2 = &q->queue[entry_pos2];

      if (entry1->Depth > entry2->Depth) {
         temp_entry = *entry1;
         *entry1 = *entry2;
         *entry2 = temp_entry;
         pq_balance (q, entry_pos2);
         }
      }

   if (entry_pos1 / 2 >= 1 )
      {
      entry_pos2 = entry_pos1 / 2;
      entry2 = &q->queue[entry_pos2];
      if (entry1->Depth < entry2->Depth) {
         temp_entry = *entry1;
         *entry1 = *entry2;
         *entry2 = temp_entry;
         pq_balance (q, entry_pos2);
         }
      }
   }

void pq_add (q, entry)
   PRIOQ *q;
   INTERSECTION *entry;
   {
   q -> current_entry++;
   if (q -> current_entry >= q -> queue_size)
      q -> current_entry--;

   q -> queue [q -> current_entry] = *entry;
   pq_balance (q, q -> current_entry);
   }

INTERSECTION *pq_get_highest(q)
   PRIOQ *q;
   {
   if (q -> current_entry >= 1)
      return (&(q -> queue[1]));
   else
      return (NULL);
   }

int pq_is_empty(q)
   PRIOQ *q;
   {
   if (q -> current_entry < 1)
      return (TRUE);
   else
      return (FALSE);
   }

void pq_delete_highest (q)
   PRIOQ *q;
   {
   q -> queue[1] = q -> queue[q -> current_entry--];
   pq_balance (q, 1);
   }

